<?php
//----------------------------------------------------------------------------
// Classes to group rules together, allowing for complex structures.
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

class ValidateRuleList implements ValidateRuleCollection
{
  private $rules=[];

  function addRule(ValidateRule $rule) : ValidateRuleCollection
  {
    $this->rules[] = $rule;
    return $this;
  }

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    foreach ($this->rules as $rule)
    {
      $resultsSoFar = $rule->extract($source,$resultsSoFar);
    }
    return $resultsSoFar;
  }

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
