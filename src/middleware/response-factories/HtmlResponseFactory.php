<?php
//----------------------------------------------------------------------------
// Response factory for all GET requests expecting to return HTML
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

use Latte\Engine;
use Latte\Loaders\FileLoader;
use Jaypha\Jayponents\Component;
use Jaypha\Jayponents\Latte\LatteEngineAdaptor;

class HtmlResponseFactory implements ResponseFactory
{
  function __construct()
  {
  }

  function mimeType() { return "text/html"; }

  function gracefulExit($code)
  {
    http_response_code($code);
    readfile("website/$code.html", true);
  }

  function reject($message, $code)
  {
    http_response_code($code);
    readfile("website/$code.html", true);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
