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

class LatteHtmlResponseFactory extends HtmlResponseFactory
{
  function __construct($srcDir = \Config\SRC_ROOT, $cacheDir = \Config\VAR_ROOT."/latte-cache")
  {
    parent::__construct();
    $latte = new Engine();
    $latte->setTempDirectory($cacheDir);
    $latte->setLoader(new FileLoader($srcDir));
    Component::setDefaultEngine(new LatteEngineAdaptor($latte));
  }
}

//----------------------------------------------------------------------------

class LatteHtmlOutput extends LatteHtmlResponseFactory implements Middleware
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
