<?php
//----------------------------------------------------------------------------
// Bootstrap for all GET requests expecting to return HTML
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

use Latte\Engine;
use Latte\Loaders\FileLoader;
use Jaypha\Jayponents\Component;
use Jaypha\Jayponents\LatteTemplateEngineAdaptor;

class HtmlResponseFactory implements ResponseFactory
{
  function __construct()
  {
    $latte = new Engine();
    $latte->setTempDirectory(\Config\APP_ROOT."/var/latte-cache");
    $latte->setLoader(new FileLoader(\Config\APP_ROOT."/src"));
    Component::setDefaultTemplateAdaptor(new LatteTemplateEngineAdaptor($latte));
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
