<?php
//----------------------------------------------------------------------------
// More advanced rules
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

class ConditionalRule implements ValidateRule
{
  private $evaluation;

  //-------------------------------------------------------

  function __construct(Evaluation $evaluation, ValidateRule $rule)
  {
    $this->evaluation = $evaluation;
    $this->rule = $rule;
  }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    if ($this->evaluation->evaluate($resultsSoFar))
    {
      $resultsSoFar = $this->rule->extract($source, $resultsSoFar);
    }
    return $resultsSoFar;
  } 

  //-------------------------------------------------------

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    return $this;
  }
}

//----------------------------------------------------------------------------

class SwitchRule implements ValidateRule
{
  private $evaluation;
  private $rules = [];

  //-------------------------------------------------------

  function __construct(Evaluation $evaluation)
  {
    $this->evaluation = $evaluation;
  }

  //-------------------------------------------------------

  function addRuleCase(string $value, ValidateRule $rule) : SwitchRule
  {
    $this->rules[$value] = $rule;
    return $this;
  }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    $v = $this->evaluation->evaluate($resultsSoFar);
    if (!isset($this->rules[$v]))
      throw new \Exception("Value $v not supported");

    $resultsSoFar = $this->rules[$v]->extract($source, $resultsSoFar);
    return $resultsSoFar;
  } 

  //-------------------------------------------------------

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    return $this;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
