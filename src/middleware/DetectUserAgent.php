<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class DetectUserAgent implements Middleware
{
  public function handle($input, Service $service)
  {
    global $rdb;

    if (!isset($_SESSION["isIE11"]))
    {
      // IE 10 or earlier not supported
      if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE"))
      {
        return get_file_contents(__DIR__."/old-browser.html");
      }

      // IE 11 requires special handling in some places
      $_SESSION["isIE11"] = (bool) strpos($_SERVER["HTTP_USER_AGENT"], "Trident");

      // Mobiles also sometimes require special handling.    
      $mobileDetect = new \Mobile_Detect();
      $_SESSION["isMobile"] = $mobileDetect->isMobile();
    }

    return $service->next($input);
  }

  static function isIE11() { return $_SESSION["isIE11"] ?? false; }
  static function isMobile() { return $_SESSION["isMobile"] ?? false; }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
