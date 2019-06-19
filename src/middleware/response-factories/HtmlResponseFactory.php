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
    readfile("website/$code.html", true);
  }

  function reject($message, $code)
  {
    readfile("website/$code.html", true);
  }
}

//----------------------------------------------------------------------------

class HtmlOutput extends HtmlResponseFactory implements Middleware
{
  public function handle($input, Service $service)
  {
    $service->setResponseFactory($this);
    $output = $service->next($input);

    if (is_array($output))
    {
      return new StringInputStream($output);
    }
    else
    {
      assert(is_string($output) || $output instanceof InputStream);
      return $output;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
