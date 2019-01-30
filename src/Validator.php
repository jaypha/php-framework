<?php
//----------------------------------------------------------------------------
// Functions to extract and validate various kinds of input
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

class Validator
{
  protected $rules;

  //-----------------------------------------------

  function __construct($rules) { $this->rules = $rules; }

  //-----------------------------------------------

  function validate($source)
  {
    $values = []; $failures = [];
    foreach ($this->rules as $name => $rule)
    {
      $varType = $rule["type"];
      $required = (!array_key_exists("required",$rule) || $rule["required"]);
      switch ($varType)
      {
        case "id":
          $r = self::extractId($source, $name, $required);
          break;
        case "enumerated":
          $r = self::extractEnumerated($source, $name, $rule);
          break;
        case "boolean":
          $r = self::extractBoolean($source, $name);
          break;
        default:
          $f = "extract".ucfirst($varType);
          $r = self::$f($source, $name, $required, $rule);
      }
      if (isFailure($r))
        $failures[$name] = $r->reason;
      else
        $values[$name] = $r;
    }
    return [ "success" => count($failures) == 0, "values" => $values, "failures" => $failures ];
  }

  //------------------------------------------------------------

  const FAIL_MISSING = "missing";
  const FAIL_TOO_SHORT = "too-short";
  const FAIL_TOO_LONG = "too-long";
  const FAIL_MISMATCH = "mismatch";
  const FAIL_TOO_LOW = "too-low";
  const FAIL_TOO_HIGH = "too-high";

  const REGEX_NUMBER = "/^(\+|-)?\d+(\.\d+)?$/";
  const REGEX_INTEGER = "/^(\+|-)?\d+$/";
  const REGEX_ISO_DATE = "/^\d{4}-?\d{2}-?\d{2}$/";

  //-----------------------------------------------

  static function extractId(array $source, string $name, bool $required = true)
  {
    if (!array_key_exists($name, $source) || $source[$name] == "")
      return $required ? new Failure(self::FAIL_MISSING) : null;

    $r = self::validateId($source[$name]);
    return ($r === true) ? $source[$name] : $r;
  }

  static function validateId($value)
  {
    if (!is_int($value))
    {
      if (!ctype_digit($value))
        return new Failure(self::FAIL_MISMATCH);
    }
    if ($value <= 0)
      return new Failure(self::FAIL_MISMATCH);
    return true;
  }

  //-----------------------------------------------

  static function extractString(
    array $source,
    string $name,
    bool $required = true,
    array $constraints = []
  )
  {
    if (!array_key_exists($name, $source) || $source[$name] == "")
      return $required ? new Failure(self::FAIL_MISSING) : "";

    $r = self::validateString($source[$name], $constraints);
    return ($r === true) ? $source[$name] : $r;
  }

  //-----------------------------------------------

  static function validateString(
    string $value,
    array $constraints = []
  )
  {
    if (array_key_exists("regex", $constraints))
    {
      assert(is_string($constraints["regex"]));
      if (!preg_match($constraints["regex"], $value))
        return new Failure(self::FAIL_MISMATCH);
    }
    if (array_key_exists("minLength", $constraints))
    {
      assert(
        ctype_digit($constraints["minLength"]) ||
        (is_int($constraints["minLength"]) && $constraints["minLength"] > 0)
      );
      if (strlen($value) < $constraints["minLength"])
        return new Failure(self::FAIL_TOO_SHORT);
    }
    if (array_key_exists("maxLength", $constraints))
    {
      assert(
        ctype_digit($constraints["maxLength"]) ||
        (is_int($constraints["maxLength"]) && $constraints["maxLength"] > 0)
      );
      if (strlen($value) > $constraints["maxLength"])
        return new Failure(self::FAIL_TOO_LONG);
    }
    return true;
  }

  //-----------------------------------------------

  static function extractBoolean(array $source, string $name)
  {
    if (!array_key_exists($name, $source))
      return false;
    else if (strtolower($source[$name]) == "false")
      return false;
    else
      return (bool) $source[$name];
  }

  //-----------------------------------------------

  static function extractInteger(
    array $source,
    string $name,
    bool $required = true,
    array $constraints = []
  )
  {
    if (!array_key_exists($name, $source) || $source[$name] == "")
      return $required ? new Failure(self::FAIL_MISSING) : null;

    $r = self::validateInteger($source[$name], $constraints);
    return ($r === true) ? $source[$name] : $r;
  }

  //-----------------------------------------------

  static function validateInteger(
    string $value,
    array $constraints = []
  )
  {
    if (!preg_match(self::REGEX_INTEGER, $value))
      return new Failure(self::FAIL_MISMATCH);

    if (array_key_exists("max", $constraints))
    {
      assert(is_int($constraints["max"]) || self::validateInteger($constraints["max"]));
      if ($value > $constraints["max"])
        return new Failure(self::FAIL_TOO_HIGH);
    }
    if (array_key_exists("min", $constraints))
    {
      assert(is_int($constraints["min"]) || self::validateInteger($constraints["min"]));
      if ($value < $constraints["min"])
        return new Failure(self::FAIL_TOO_HIGH);
    }
    return true;
  }

  //-----------------------------------------------

  static function extractNumber(
    array $source,
    string $name,
    bool $required = true,
    array $constraints = []
  )
  {
    if (!array_key_exists($name, $source) || $source[$name] == "")
      return $required ? new Failure(self::FAIL_MISSING) : "";

    $r = self::validateNumber($source[$name], $constraints);
    return ($r === true) ? $source[$name] : $r;
  }

  //-----------------------------------------------

  static function validateNumber(
    string $value,
    array $constraints = []
  )
  {
    if (!preg_match(self::REGEX_NUMBER, $value))
      return new Failure(self::FAIL_MISMATCH);

    if (array_key_exists("max", $constraints))
    {
      assert(is_numeric($constraints["max"]));
      if ($value > $constraints["max"])
        return new Failure(self::FAIL_TOO_HIGH);
    }
    if (array_key_exists("min", $constraints))
    {
      assert(is_numeric($constraints["min"]));
      if ($value > $constraints["min"])
        return new Failure(self::FAIL_TOO_LOW);
    }
    return $true;
  }

  //-----------------------------------------------

  static function extractEnumerated(
    array $source,
    string $name,
    array $constraints = []
  )
  {
    if (!array_key_exists("minCount", $constraints))
      $constraints["minCount"] = 0;
    if (!array_key_exists("maxCount", $constraints))
      $constraints["maxCount"] = 1;

    if (!array_key_exists($name, $source) || $source[$name] == "")
    {
      if ($constraints["minCount"] != 0)
        return new Failure(self::FAIL_MISSING);
      if ($constraints["maxCount"] >1)
        return [];
      else
        return null;
    }
 
    $r = self::validateEnumerated($source[$name], $constraints);
    return ($r === true) ? $source[$name] : $r;
  }

  //-----------------------------------------------

  static function validateEnumerated(
    $value,
    array $constraints = []
  )
  {
    if (!array_key_exists("minCount", $constraints))
      $constraints["minCount"] = 0;
    if (!array_key_exists("maxCount", $constraints))
      $constraints["maxCount"] = 1;
    if (!is_array($value)) $value = [ $value ];

    if (count($value) < $constraints["minCount"])
      return new Failure(FAIL_TOO_SHORT);
    if (count($value) > $constraints["maxCount"])
      return new Failure(FAIL_TOO_LONG);

    if (array_key_exists("options", $constraints))
      foreach ($value as $v)
        if (!in_array($v, $constraints["options"]))
          return new Failure(FAIL_MISMATCH);

    return true;
  }

  //-----------------------------------------------

  static function extractDate(
    array $source,
    string $name,
    bool $required = true,
    array $constraints = []
  )
  {
    if (!array_key_exists($name, $source) || $source[$name] == "")
      return $required ? new Failure(self::FAIL_MISSING) : "";

    $r = self::validateDate($source[$name], $constraints);
    return ($r === true) ? $source[$name] : $r;
  }

  //-----------------------------------------------

  static function validateDate(
    string $value,
    array $constraints = []
  )
  {
    if (!preg_match(self::REGEX_ISO_DATE, $value))
      return new Failure(self::FAIL_MISMATCH);

    return true;
  }

}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//

