<?php
//----------------------------------------------------------------------------
// Common rules used to validate values
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

class RequiredRule extends ValidateRuleBase
{
  private $name;

  //-------------------------------------------------------

  function __construct(string $name) { $this->name = $name; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    if (
      !array_key_exists($this->name, $source) ||
      $source[$this->name] == "" ||
      $source[$this->name] === []
    )
    {
      $message = $this->errorFormats[FAIL_MISSING] ?? null;
      $resultsSoFar[$this->name] = new Fail(FAIL_MISSING, $message);
    }
    else
      $resultsSoFar[$this->name] = $source[$this->name];
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class DefaultRule extends ValidateRuleBase
{
  private $name, $default;

  //-------------------------------------------------------

  function __construct(string $name, ?string $default = null) { $this->name = $name; $this->default = $default; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    if (!array_key_exists($this->name, $source) ||
      $source[$this->name] == "" ||
      $source[$this->name] === []
    )
      $resultsSoFar[$this->name] = $this->default;
    else
      $resultsSoFar[$this->name] = $source[$this->name];
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------
// IDs are considered to be all digits, therefore can be checked using ctype

class IdRule extends ValidateRuleBase
{
  private $name, $pattern;

  //-------------------------------------------------------

  function __construct(string $name) { $this->name = $name; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
      if (!ctype_digit($resultsSoFar[$this->name]))
      {
        $message = $this->errorFormats[FAIL_INVALID] ?? null;
        $resultsSoFar[$this->name] = new Fail(FAIL_INVALID, $message);
      }

    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class PatternRule extends ValidateRuleBase
{
  private $name;

  public $pattern;

  //-------------------------------------------------------

  function __construct(string $name, string $pattern) { $this->name = $name; $this->pattern = $pattern; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    $matching = preg_match($this->pattern, $resultsSoFar[$this->name]);
    if ($matching === false) throw new \RuntimeException("Pattern rule failed");
    if ($matching == 0)
    {
      $message = $this->errorFormats[FAIL_INVALID] ?? null;
      $resultsSoFar[$this->name] = new Fail(FAIL_INVALID, $message);
    }

    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class MinLengthRule extends ValidateRuleBase
{
  private $name, $minLength;

  //-------------------------------------------------------

  function __construct(string $name, int $minLength) { $this->name = $name; $this->minLength = $minLength; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    if (strlen($resultsSoFar[$this->name]) < $this->minLength)
    {
      $message = $this->errorFormats[FAIL_TOO_SHORT] ?? null;
      $resultsSoFar[$this->name] = new Fail(FAIL_TOO_SHORT, str_replace("%m", $this->minLength,  $message));
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class MaxLengthRule extends ValidateRuleBase
{
  private $name, $maxLength;

  //-------------------------------------------------------

  function __construct(string $name, int $maxLength) { $this->name = $name; $this->maxLength = $maxLength; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    if (strlen($resultsSoFar[$this->name]) > $this->maxLength)
    {
      $message = $this->errorFormats[FAIL_TOO_LONG] ?? null;
      $resultsSoFar[$this->name] = new Fail(FAIL_TOO_LONG, str_replace("%m", $this->maxLength, $message));
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class IsOneOfRule extends ValidateRuleBase
{
  private $name, $options;

  //-------------------------------------------------------

  function __construct(string $name, iterable $options) { $this->name = $name; $this->options = $options; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    {
      $val = $resultsSoFar[$this->name];
      if (!is_iterable($val))
        $val = [ $val ];
      foreach ($val as $v)
        if (!in_array($v, $this->options))
        {
          $message = $this->errorFormats[FAIL_INVALID] ?? null;
          $resultsSoFar[$this->name] = new Fail(FAIL_INVALID, $message);
          break;
        }
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class MinCountRule extends ValidateRuleBase
{
  private $name, $minCount;

  //-------------------------------------------------------

  function __construct(string $name, int $minCount) { $this->name = $name; $this->minCount = $minCount; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    {
      $val = $resultsSoFar[$this->name];
      if (!is_iterable($val))
        $val = [ $val ];
      if (count($val) < $this->minCount)
      {
        $message = $this->errorFormats[FAIL_TOO_LOW] ?? null;
        $resultsSoFar[$this->name] = new Fail(FAIL_TOO_LOW, str_replace("%m", $this->minCount,  $message));
      }
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class MinimumRule extends ValidateRuleBase
{
  private $name, $min;

  //-------------------------------------------------------

  function __construct(string $name, int $min) { $this->name = $name; $this->min = $min; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    {
      $val = $resultsSoFar[$this->name];

      assert(preg_match(REGEX_NUMBER, $resultsSoFar[$this->name]) !== false);

      if ($val < $this->min)
      {
        $message = $this->errorFormats[FAIL_TOO_LOW] ?? null;
        $resultsSoFar[$this->name] = new Fail(FAIL_TOO_LOW, str_replace("%m", $this->min,  $message));
      }
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class MaximumRule extends ValidateRuleBase
{
  private $name, $max;

  //-------------------------------------------------------

  function __construct(string $name, int $max) { $this->name = $name; $this->max = $max; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    {
      $val = $resultsSoFar[$this->name];

      assert(preg_match(REGEX_NUMBER, $resultsSoFar[$this->name]) !== false);

      if ($val > $this->max)
      {
        $message = $this->errorFormats[FAIL_TOO_HIGH] ?? null;
        $resultsSoFar[$this->name] = new Fail(FAIL_TOO_HIGH, str_replace("%m", $this->max,  $message));
      }
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------

class MaxCountRule extends ValidateRuleBase
{
  private $name, $maxCount;

  //-------------------------------------------------------

  function __construct(string $name, int $maxCount) { $this->name = $name; $this->maxCount = $maxCount; }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!($resultsSoFar[$this->name] instanceof Fail))
    {
      $val = $resultsSoFar[$this->name];
      if (!is_iterable($val))
        $val = [ $val ];
      if (count($val) > $this->maxCount)
      {
        $message = $this->errorFormats[FAIL_TOO_HIGH] ?? null;
        $resultsSoFar[$this->name] = new Fail(FAIL_TOO_HIGH, str_replace("%m", $this->maxCount,  $message));
      }
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
