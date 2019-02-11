<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class Timezone implements Middleware
{
  public function handle(
    $input,
    Service $service
  )
  {
    if (isset($_COOKIE["tzoffset"]))
    {
      $hours = $_COOKIE["tzoffset"]/3600;
      $h = floor($hours);
      $m = floor(($hours - $h) * 60);
      $GLOBALS["timezone"] = new \DateTimeZone(sprintf("%+03d%02d",$h,$m));
    }
    else if (isset($_COOKIE["tz_offset"]))
    {
      $hours = $_COOKIE["tz_offset"]/60;
      $h = floor($hours);
      $m = floor(($hours - $h) * 60);
      $GLOBALS["timezone"] = new \DateTimeZone(sprintf("%+03d%02d",$h,$m));
    }
    else
      $GLOBALS["timezone"] = null;

    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
