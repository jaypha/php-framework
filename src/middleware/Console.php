<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class Console implements ResponseFactory, Middleware
{
  function __construct() {}

  function mimeType() { return "text/plain"; }

  function gracefulExit($code)
  {
    fwrite(STDERR, "Error: $code\n");
  }

  function reject($message, $code)
  {
    return "Rejected: ($code) $message, \n";
  }

  function handle($input, Service $service)
  {
    $service->setResponseFactory($this);

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
