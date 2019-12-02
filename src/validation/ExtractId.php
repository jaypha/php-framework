<?php
//----------------------------------------------------------------------------
// Extracts and ID value (all digits) from the source
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class ExtractId extends ExtractValue
{
  static function ExtractId(iterable $source, iterable $resultsSoFar, string $name, bool $isRequired)
  {
    $rule = new ExtractId($name, $isRquired);
    return $rule->extract($source, $resultsSoFar);
  }

  function __construct(string $name, bool $isRequired = false)
  {
    parent::__construct($name, $isRequired);
    $patternRule = new IdRule($name);
    $this->addRule($patternRule);
  }
}

// quick and dirty alternative, returns false instead of Fail.
function extractId($source, $name, $isRequired = true)
{
  if (isset($source[$name]) && $source[$name] != "")
  {
    if (ctype_digit($source[$name]))
      return $source[$name];
  } else if (!$isRequired)
    return null;
  
  return false;
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
