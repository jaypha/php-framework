<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

use Latte\Engine;
use Latte\Loaders\FileLoader;
use Jaypha\Jayponents\Component;
use Jaypha\Jayponents\Latte\LatteEngineAdaptor;

class UseLatteEngine implements Middleware
{
  function __construct($srcDir = \Config\SRC_ROOT, $cacheDir = \Config\VAR_ROOT."/latte-cache")
  {
    $latte = new Engine();
    $latte->setTempDirectory($cacheDir);
    $latte->setLoader(new FileLoader($srcDir));
    Component::setDefaultEngine(new LatteEngineAdaptor($latte));
  }

  public function handle($input, Service $service)
  {
    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
