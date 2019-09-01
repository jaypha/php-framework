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
    $failures = [];
    foreach ($this->failures as $name => $failure)
      $failures[$name] = $failure->message;
    return $failures;
  }

  function getFailuresAsString()
  {
    return implode("\n", $this->getFailuresAsArray());
  }

  // Json is for responsing to ajax form submission
  function getFailuresAsJson()
  {
    return [
      "success" => false,
      "message" => $this->getFailuresAsString(),
      "failures" => $this->getFailuresAsArray()
    ];
  }
}
//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
