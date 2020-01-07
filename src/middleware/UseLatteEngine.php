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
  protected $latte;

  function __construct($srcDir = \Config\SRC_ROOT, $cacheDir = \Config\VAR_ROOT."/latte-cache")
  {
    $this->latte = new Engine();
    $this->latte->setTempDirectory($cacheDir);
    $this->latte->setLoader(new \Jaypha\IncludePathFileLoader());
    Component::setDefaultEngine(new LatteEngineAdaptor($this->latte));

    $this->latte->addFilter('makenb', function ($s) {
      return str_replace(" ", "\u{00a0}", $s);
    });
  }

  function setLoader($loader) { $this->latte->setLoader($loader); return $this; }

  function setTempDirectory($tempDir) { $this->latte->setTempDirectory($tempDir); return $this; }

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
