<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class TextControl extends InputControl
{
  const FAIL_TOO_SHORT_FORMAT = "The value for '%l' must be at least %m characters long";
  const FAIL_TOO_LONG_FORMAT = "The value for '%l' must be at most %m characters long";

  function __construct($name)
  {
    $this->validator = new \Jaypha\ExtractText($name);
    parent::__construct($name);
    $this->attributes["type"]="text";
  }

  //-------------------------------------------------------
  // Validation methods

  // TODO: check if pattern must match whole string in HTML
  function setPattern($pattern, $failMessageFormat = null)
  {
    if (!$failMessageFormat)
      $failMessageFormat = self::FAIL_INVALID_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setPattern($pattern,  $failMessageFormat);
  }

  function setMinLength($minLength, $failMessageFormat = null)
  {
    if ($failMessageFormat)
      $failMessageFormat = self::FAIL_TOO_SHORT_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setMinLength($minLength,  $failMessageFormat);
  }

  function setMaxLength($maxLength, $failMessageFormat = null)
  {
    if ($failMessageFormat)
      $failMessageFormat = self::FAIL_TOO_LONG_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setMaxLength($maxLength,  $failMessageFormat);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
