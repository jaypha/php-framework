<?php
//----------------------------------------------------------------------------
// Extracts a value from the source and, if found, applies other rules
//----------------------------------------------------------------------------

namespace Jaypha;

class ExtractValue extends ValidateRuleBase implements ValidateRuleCollection
{
  protected $name, $isRequired, $default = null;
  private $validateRules;

  function __construct(string $name, bool $isRequired = true, $default = null)
  {
    $this->name = $name;
    $this->isRequired = $isRequired;
    $this->default = $default;
    $this->validateRules = new ValidateRuleList();
  }

  function setRequired(bool $isRequired, $failMessageFormat = null) : ExtractValue
  {
    $this->isRequired = $isRequired;
    if ($failMessageFormat)
      $this->setFailMessageFormat(FAIL_MISSING, $failMessageFormat);
    return $this;
  }

  function setDefault(?string $default) : ExtractValue
  { $this->default = $default; $this->isRequired = false; return $this; }

  function addRule(ValidateRule $rule) : ValidateRuleCollection
  {
    $this->validateRules->addRule($rule);
    return $this;
  }

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    if (!array_key_exists($this->name, $source) ||
        $source[$this->name] == "" ||
        $source[$this->name] === [])
    {
      if ($this->isRequired)
      {
        $message = $this->errorFormats[FAIL_MISSING] ?? null;
        $resultsSoFar[$this->name] = new Fail(FAIL_MISSING, $message);
      }
      else
        $resultsSoFar[$this->name] = $this->default;
    }
    else
    {
      $resultsSoFar[$this->name] = $source[$this->name];
      $resultsSoFar = $this->validateRules->extract($source, $resultsSoFar);
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
