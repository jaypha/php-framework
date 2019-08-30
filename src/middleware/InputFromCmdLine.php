<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class InputFromCmdLine implements Middleware
{
  function handle($input, $service)
  {
    $input = array_slice($GLOBALS["argv"], 1);
    $service->setInput($input);
    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
