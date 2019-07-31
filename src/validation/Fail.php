<?php
//----------------------------------------------------------------------------
// Class to represent a failure that is not an error.
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------
// Common failure reasons.

const FAIL_MISSING = "missing";
const FAIL_TOO_SHORT = "too-short";
const FAIL_TOO_LONG = "too-long";
const FAIL_INVALID = "invalid";
const FAIL_TOO_LOW = "too-low";
const FAIL_TOO_HIGH = "too-high";

//----------------------------------------------------------------------------

class Fail
{
  public $code;    // Machine readable
  public $message; // Human readable (optional)

  function __construct(string $code, ?string $message = null)
  {
    $this->code = $code; $this->message = $message;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
