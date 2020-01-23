<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Jaypha\Jayponents\Html;

class ExtractNumber extends ExtractValue
{
  private $constraints;
  private $patternRule;
  private $minRule, $maxRule, $precisionRule;

  function __construct(string $name, array $constraints = [])
  {
    $default = $constraints["default"] ?? "";
    $required = $constraints["required"] ?? false;

    $this->constraints = $constraints;
    parent::__construct($name, $required, $default);

    $this->patternRule = new PatternRule($this->name, REGEX_NUMBER);
    $this->addRule($this->patternRule);

    if (isset($constraints["min"]))
      $this->setMin($constraints["min"]);
    if (isset($constraints["max"]))
      $this->setMax($constraints["max"]);
    if (isset($constraints["precision"]))
      $this->setPrecision($constraints["precision"]);
  }

  function setMin($min, $failMessageFormat = null)
  {
    $this->minRule = new MinimumRule($this->name, $min);
    $this->addRule($this->minRule);
    if ($failMessageFormat)
      $this->minRule->setFailMessageFormat(FAIL_TOO_LOW,$failMessageFormat);
  }

  function setMax($max, $failMessageFormat = null)
  {
    $this->maxRule = new MaximumRule($this->name, $max);
    $this->addRule($this->maxRule);
    if ($failMessageFormat)
      $this->maxRule->setFailMessageFormat(FAIL_TOO_HIGH,$failMessageFormat);
  }

  function setPrecision(int $numDecimalPlaces, $failMessageFormat = null)
  {
    assert($numDecimalPlaces >= 0);
    if ($numDecimalPlaces == 0)
      $this->patternRule->pattern = REGEX_INTEGER;
    else
      $this->patternRule->pattern = "/^(\+|-)?\d+(\.\d{1,$numDecimalPlaces})?$/";
    if ($failMessageFormat)
      $this->patternRule->setFailMessageFormat(FAIL_INVALID,$failMessageFormat);
  }

  //-------------------------------------------------------

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    switch ($code)
    {
      case FAIL_INVALID:
        assert($this->patternRule);
        $this->patternRule->setFailMessageFormat(FAIL_INVALID,$format);
        break;
      case FAIL_TOO_LOW:
        assert($this->minLengthRule);
        $this->minLengthRule->setFailMessageFormat(FAIL_TOO_LOW,$format);
        break;
      case FAIL_TOO_HIGH:
        assert($this->maxlengthRule);
        $this->maxlengthRule->setFailMessageFormat(FAIL_TOO_HIGH,$format);
        break;
      default:
        parent::setFailMessageFormat($code, $format);
    }

    return $this;
  }

  //-------------------------------------------------------

  static function ExtractNumber($source, $resultsSoFar, $name, $constraints)
  {
    $rule = new ExtractNumber($name, $constraints);
    return $rule->extract($source, $resultsSoFar);
  }
}

//----------------------------------------------------------------------------

class ExtractInteger extends ExtractNumber
{
  function __construct(string $name, array $constraints = [])
  {
    $constraints["precision"] = 0;
    parent::__construct($name, $constraints);
  }

  function setPrecision(int $numDecimalPlaces, $failMessageFormat = null)
  {
  }

  //-------------------------------------------------------

  static function ExtractInteger($source, $resultsSoFar, $name, $constraints)
  {
    $rule = new ExtractInteger($name, $constraints);
    return $rule->extract($source, $resultsSoFar);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
