<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ConsoleInput implements Middleware
{
  function handle($input, Service $service)
  {
    return $service->next($GLOBALS["argv"]);
  }          
}


//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
