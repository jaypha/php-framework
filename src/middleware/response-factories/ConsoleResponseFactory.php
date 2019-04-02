<?php
//----------------------------------------------------------------------------
// Response factory for console execution
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ConsoleResponseFactory implements ResponseFactory
{
  function __construct()
  {
  }

  function mimeType() { return "text/plain"; }

  function gracefulExit($code)
  {
    echo "Error: $code\n";
  }

  function reject($message, $code)
  {
    echo "Error: $message, ($code)\n";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
