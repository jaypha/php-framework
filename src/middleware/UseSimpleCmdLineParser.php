<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class UseSimpleCmdLineParser implements Middleware
{
  function handle($input, Service $service)
  {
    $input = array_slice($GLOBALS["argv"], 1);
    $numberedParams = [];
    $namedParams = [];
    foreach ($input as $arg) {
    if ($arg[0] == '-')
      {
        $arg = ltrim($arg, "-");
        [$name, $arg] = strpos($arg, '=') ? explode('=', $arg,2) : [$arg, true];
        $namedParams[$name] = $arg;
      }
      else
        $numberedParams[] = $arg;
    }
    return $service->next($namedParams + $numberedParams);
  }          
}


//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
