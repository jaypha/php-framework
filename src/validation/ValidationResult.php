<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class ValidationResult
{
  public $success = true;
  public $failures = [], $values = [];
  
  function __construct($result)
  {
    foreach ($result as $name => $r)
    {
      if ($r instanceof Fail)
      {
        $this->failures[$name] = $r;
        $this->success = false;
      }
      else
        $this->values[$name] = $r;
    }
  }

  function getFailuresAsArray()
  {
    $message = [];
    foreach ($this->failures as $failure)
      $message[] = $failure->message;
    return $message;
  }

  function getFailuresAsString()
  {
    return implode("\n", $this->getFailuresAsArray());
  }
}
//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
