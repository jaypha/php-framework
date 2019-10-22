<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class CheckboxControl extends InputControl
{
  const FAIL_MISSING_FORMAT = "You must check the box '%l'";

  function __construct($name)
  {
    $this->validator = new \Jaypha\ExtractText($name);
    parent::__construct($name);
    $this->attributes["type"]="checkbox";
  }

  function asBoolean($isBool = true)
  {
    if ($isBool)
      $this->validator = new \Jaypha\ExtractBoolean($this->name);
    else
      $this->validator = new \Jaypha\ExtractText($this->name);
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
