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

class LatteHtmlResponseFactory implements HtmlResponseFactory
{
  function __construct()
  {
    parent::__contruct();
    $latte = new Engine();
    $latte->setTempDirectory(\Config\VAR_ROOT."/latte-cache");
    $latte->setLoader(new FileLoader(\Config\APP_ROOT."/src"));
    Component::setDefaultEngine(new LatteEngineAdaptor($latte));
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
