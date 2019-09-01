<?php
//----------------------------------------------------------------------------
// Encapsulates a bunch of validation rules related to text strings.
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

class ExtractText extends ExtractValue
{
  private $constraints;
  private $patternRule, $minLengthRule, $maxlengthRule;

  //-------------------------------------------------------

  function __construct(string $name, array $constraints = [])
  {
    $default = $constraints["default"] ?? "";
    $required = $constraints["required"] ?? false;

    $this->constraints = $constraints;
    parent::__construct($name, $required, $default);

    if (isset($constraints["pattern"]))
      $this->setPattern($constraints["pattern"]);
    if (isset($constraints["minLength"]))
      $this->setMinLength($constraints["minLength"]);
    if (isset($constraints["maxLength"]))
      $this->setMaxLength($constraints["maxLength"]);
  }

  //-------------------------------------------------------

  function setPattern($pattern, $failMessageFormat = null)
  {
    $this->patternRule = new PatternRule($this->name, $pattern);
    $this->addRule($this->patternRule);
    if ($failMessageFormat)
      $this->patternRule->setFailMessageFormat(FAIL_INVALID,$failMessageFormat);
  }

  //-------------------------------------------------------

  function setMinLength($minLength, $failMessageFormat = null)
  {
    $this->minLengthRule = new MinLengthRule($this->name, $minLength);
    $this->addRule($this->minLengthRule);
    if ($failMessageFormat)
      $this->minLengthRule->setFailMessageFormat(FAIL_TOO_SHORT,$failMessageFormat);
  }

  //-------------------------------------------------------

  function setMaxLength($maxLength, $failMessageFormat = null)
  {
    $this->maxLengthRule = new MaxLengthRule($this->name, $minLength);
    $this->addRule($this->maxlengthRule);
    if ($failMessageFormat)
      $this->maxLengthRule->setFailMessageFormat(FAIL_TOO_LONG,$failMessageFormat);
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
      case FAIL_TOO_SHORT:
        assert($this->minLengthRule);
        $this->minLengthRule->setFailMessageFormat(FAIL_TOO_SHORT,$format);
        break;
      case FAIL_TOO_LONG:
        assert($this->maxlengthRule);
        $this->maxlengthRule->setFailMessageFormat(FAIL_TOO_LONG,$format);
        break;
      default:
        parent::setFailMessageFormat($code, $format);
    }

    return $this;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
