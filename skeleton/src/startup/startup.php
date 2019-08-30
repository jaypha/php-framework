<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use Jaypha\Middleware as MW;

const IS_CONSOLE = false;

require \Config\APP_ROOT."/config.php";

require "require.php";

\setErrorHandlers();
\setLogger(new \Jaypha\ProductionLogger());
session_start();

assert((function()
  {
    \setLogger(new \Jaypha\DevLogger());
    return true;
  }
)());

$service = new MW\Service();

$service
  ->add(new MW\DetectUserAgent())
//  ->add("\Jaypha\Middleware\setTimeZone")
  ->add(new MW\UseMysql())
//  ->add(
//    new MW\SetContentSecurityPolicy([
//     "default-src" => [ "'self'" ],
//     "style-src" => [ "'self'", "'unsafe-inline'" ],
//     "script-src" => [ "'self'", "'unsafe-inline'" ],
//     "report-uri" => "/csp/report.php"
//    ], true)
//  )
;

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
