<?php
//----------------------------------------------------------------------------
// A more sophisticated approach to handle failures that do not require an
// exception to be thrown.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

class Failure
{
  public $reason; // Readable string containing the reason
  public $errNo;  // Optional error number for machine handling

  function __construct($r, $n = 0) { $this->reason = $r; $this->errNo = $n; }
}

function isFailure($o)
{
  return $o instanceof Failure;
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
