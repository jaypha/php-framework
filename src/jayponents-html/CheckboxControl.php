<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class CheckboxControl extends CheckableControl
{
  const FAIL_MISSING_FORMAT = "You must check the box '%l'";

  function __construct($name)
  {
    parent::__construct($name);
    $this->attributes["type"]="checkbox";
  }

  //-------------------------------------------------------
  // Validation methods

  function setRequired($required, $failMessageFormat = null)
  {
    return parent::setRequired($required, $failMessageFormat ?? self::FAIL_MISSING_FORMAT);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
