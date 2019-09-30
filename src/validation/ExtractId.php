<?php
//----------------------------------------------------------------------------
// Extracts and ID value (all digits) from the source
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class ExtractId extends ExtractValue
{
  function __construct(string $name, bool $isRequired = false)
  {
    parent::__construct($name, $isRequired);
    $this->patternRule = new IdRule($name);
    $this->addRule($this->patternRule);
  }
}

// quick and dirty alternative, returns false instead of Fail.
function extractId($source, $name, $isRequired = true)
{
  if (isset($source[$name]) && $source[$name] != "")
  {
    if (ctype_digit($source[$name]))
      return $source[$name];
  } else if (!$isRequred)
    return null;
  
  return false;
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
