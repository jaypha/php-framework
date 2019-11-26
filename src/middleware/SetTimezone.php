<?php
//----------------------------------------------------------------------------
// Extracts timezone information (if any) from cookies
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

namespace Jaypha\Middleware;

// Include this javascript into your HTML document.
const TIMEZONE_JS = "document.cookie='tzoffset='+((new Date()).getTimezoneOffset()*-60)+'; path=/';";

class SetTimezone implements Middleware
{
  public function handle($input, Service $service)
  {
    if (isset($_COOKIE["tzoffset"]))
    {
      $hours = $_COOKIE["tzoffset"]/3600;
      $h = floor($hours);
      $m = floor(($hours - $h) * 60);
      \Jaypha\setTimezone(sprintf("%+03d%02d",$h,$m));
    }
    else if (isset($_COOKIE["tz_offset"]))
    {
      $hours = $_COOKIE["tz_offset"]/60;
      $h = floor($hours);
      $m = floor(($hours - $h) * 60);
      \Jaypha\setTimezone(sprintf("%+03d%02d",$h,$m));
    }
    else
      \Jaypha\setTimezone(null);

    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
