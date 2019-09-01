<?php
//----------------------------------------------------------------------------
// Encapsulates a bunch of validation rules related to enumerations.
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

class ExtractEnum extends ExtractValue
{
  private $constraints;
  private $isOneOfRule, $minCountRule, $maxCountRule;

  public $options = null;

  //-------------------------------------------------------

  function __construct(string $name, array $constraints = [])
  {
    $default = $constraints["default"] ?? [];
    $required = $constraints["required"] ?? false;

    $this->constraints = $constraints;
    parent::__construct($name, $required, $default);

    if (isset($constraints["options"]))
      $this->setOptions($constraints["options"]);
    if (isset($constraints["minCount"]))
      $this->setMinLength($constraints["minCount"]);
    if (isset($constraints["maxCount"]))
      $this->setMaxLength($constraints["maxCount"]);
  }

  //-------------------------------------------------------

  function setOptions(iterable $options, $failMessageFormat = null)
  {
    $this->isOneOfRule = new IsOneOfRule($this->name, $options);
    $this->addRule($this->isOneOfRule);
    if ($failMessageFormat)
      $this->isOneOfRule->setFailMessageFormat(FAIL_INVALID,$failMessageFormat);
  }

  //-------------------------------------------------------

  function setMinCount(int $minCount, $failMessageFormat = null)
  {
    $this->setRequired($minCount >= 1);
    $this->minCountRule = new MinCountRule($this->name, $minCount);
    $this->addRule($this->minCountRule);
    if ($failMessageFormat)
      $this->minCountRule->setFailMessageFormat(FAIL_TOO_LOW,$failMessageFormat);
  }

  //-------------------------------------------------------

  function setMaxCount(int $maxCount, $failMessageFormat = null)
  {
    $this->maxCountRule = new MaxCountRule($this->name, $maxCount);
    $this->addRule($this->maxCountRule);
    if ($failMessageFormat)
      $this->maxCountRule->setFailMessageFormat(FAIL_TOO_HIGH,$failMessageFormat);
  }

  //-------------------------------------------------------

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    switch ($code)
    {
      case FAIL_INVALID:
        assert($this->isOneOfRule);
        $this->isOneOfRule->setFailMessageFormat(FAIL_INVALID,$format);
        break;
      case FAIL_TOO_LOW:
        assert($this->minCountRule);
        $this->minCountRule->setFailMessageFormat(FAIL_TOO_LOW,$format);
        break;
      case FAIL_TOO_HIGH:
        assert($this->maxCountRule);
        $this->maxCountRule->setFailMessageFormat(FAIL_TOO_HIGH,$format);
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
