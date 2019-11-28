<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class DateControl extends InputControl
{
  const FAIL_NOT_A_DATE = "The value for '%l' must be a valid ISO date";

  function __construct($name)
  {
    $this->validator = new \Jaypha\ExtractText($name);
    parent::__construct($name);
    $this->attributes["type"]="date";

    $this->validator->setPattern(\Jaypha\REGEX_ISO_DATE,  self::FAIL_NOT_A_DATE);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
