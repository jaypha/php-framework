<?php
//----------------------------------------------------------------------------
// A special Middleware that combines validation with processing in a single
// class.
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class Processor implements Middleware
{
  function __construct($service)
  {
    $v = $this->getValidation();
    if ($v)
      $service->add($v);
  }

  function getValidation() { return null; }

  function handle($input, $service) { return null; }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
