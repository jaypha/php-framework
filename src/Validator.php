<?php
//----------------------------------------------------------------------------
// Functions to extract and validate various kinds of input
//----------------------------------------------------------------------------
// TODO look at enum to make consistant.
//----------------------------------------------------------------------------

namespace Jaypha;

class Validator
{
  public $rules;
  protected $types = [];

  //-----------------------------------------------

  function __construct($rules) { $this->rules = $rules; }

  //-----------------------------------------------

  function addValidationType($validationType)
  {
    $this->types[$validationType->typeName()] = $validationType;
    return $this;
  }

  //-----------------------------------------------

  function validate($source)
  {
    $values = []; $failures = [];
    foreach ($this->rules as $name => $rule)
    {
      $varType = $rule["type"] ?? "string";
      $required = (!array_key_exists("required",$rule) || $rule["required"]);
      switch ($varType)
      {
        case "id":
          $r = self::extractId($source, $name, $required);
          break;
        case "enum":
        case "enumerated":
          $r = self::extractEnumerated($source, $name, $rule);
          break;
        case "boolean":
        case "bool":
          $r = self::extractBoolean($source, $name);
          break;
        case "string":
        case "integer":
        case "number":
        case "date":
          $f = "extract".ucfirst($varType);
          $r = self::$f($source, $name, $required, $rule);
          break;
        default:
          assert(isset($this->types[$varType]));
          $r = $this->types[$varType]->extract($source, $name, $required, $rule);
      }
      if ($r instanceof \Exception)
        $failures[$name] = $r->getMessage();
      else if ( isset($rule["mustMatch"]) &&
                isset($values[$rule["mustMatch"]]) &&
                $r != $values[$rule["mustMatch"]])
        $failures[$name] = self::FAIL_MISMATCH;
      $values[$name] = $r;
    }
    return [ "success" => count($failures) == 0, "values" => $values, "failures" => $failures ];
  }

  //------------------------------------------------------------

  const FAIL_MISSING = "missing";
  const FAIL_TOO_SHORT = "too-short";
  const FAIL_TOO_LONG = "too-long";
  const FAIL_INVALID = "invalid";
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
      return $required ? new \Exception(self::FAIL_MISSING) : null;

    $r = self::validateId($source[$name]);
    return ($r === true) ? $source[$name] : $r;
  }

  static function validateId($value)
  {
    if (!is_int($value))
    {
      if (!ctype_digit($value))
        return new \Exception(self::FAIL_INVALID);
    }
    if ($value <= 0)
      return new \Exception(self::FAIL_INVALID);
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
      return $required ? new \Exception(self::FAIL_MISSING) : "";

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
        return new \Exception(self::FAIL_INVALID);
    }
    else if (array_key_exists("pattern", $constraints))
    {
      assert(is_string($constraints["pattern"]));
      if (!preg_match($constraints["pattern"], $value))
        return new \Exception(self::FAIL_INVALID);
    }
    if (array_key_exists("minLength", $constraints))
    {
      assert(
        ctype_digit($constraints["minLength"]) ||
        (is_int($constraints["minLength"]) && $constraints["minLength"] > 0)
      );
      if (strlen($value) < $constraints["minLength"])
        return new \Exception(self::FAIL_TOO_SHORT);
    }
    if (array_key_exists("maxLength", $constraints))
    {
      assert(
        ctype_digit($constraints["maxLength"]) ||
        (is_int($constraints["maxLength"]) && $constraints["maxLength"] > 0)
      );
      if (strlen($value) > $constraints["maxLength"])
        return new \Exception(self::FAIL_TOO_LONG);
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
      return $required ? new \Exception(self::FAIL_MISSING) : null;

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
      return new \Exception(self::FAIL_INVALID);

    if (array_key_exists("max", $constraints))
    {
      assert(is_int($constraints["max"]) || self::validateInteger($constraints["max"]));
      if ($value > $constraints["max"])
        return new \Exception(self::FAIL_TOO_HIGH);
    }
    if (array_key_exists("min", $constraints))
    {
      assert(is_int($constraints["min"]) || self::validateInteger($constraints["min"]));
      if ($value < $constraints["min"])
        return new \Exception(self::FAIL_TOO_HIGH);
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
      return $required ? new \Exception(self::FAIL_MISSING) : null;

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
      return new \Exception(self::FAIL_INVALID);

    if (array_key_exists("max", $constraints))
    {
      assert(is_numeric($constraints["max"]));
      if ($value > $constraints["max"])
        return new \Exception(self::FAIL_TOO_HIGH);
    }
    if (array_key_exists("min", $constraints))
    {
      assert(is_numeric($constraints["min"]));
      if ($value > $constraints["min"])
        return new \Exception(self::FAIL_TOO_LOW);
    }
    return true;
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
        return new \Exception(self::FAIL_MISSING);
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
      return new \Exception(self::FAIL_TOO_SHORT);
    if (count($value) > $constraints["maxCount"])
      return new \Exception(self::FAIL_TOO_LONG);

    if (array_key_exists("options", $constraints))
      foreach ($value as $v)
        if (!in_array($v, $constraints["options"]))
          return new \Exception(self::FAIL_INVALID);

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
      return $required ? new \Exception(self::FAIL_MISSING) : null;

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
      return new \Exception(self::FAIL_INVALID);

    return true;
  }

}

//----------------------------------------------------------------------------

interface ValidatorType
{
  function typeName();
  function extract($source, $name, $required, $constraints = []);
  function validate($value, $constraints = []);
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
