<?php
//----------------------------------------------------------------------------
// Base class shared by many rules.
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

abstract class ValidateRuleBase implements ValidateRule
{
  protected $errorFormats = [];

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    $this->errorFormats[$code] = $format;
    return $this;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
