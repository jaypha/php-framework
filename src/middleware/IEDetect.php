<?php
//----------------------------------------------------------------------------
// Simple Internet Explorer detector.
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class IEDetect implements Middleware
{
  public function handle(
    $input,
    Service $service
  )
  {
    if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE"))
    {
      return $service->responseFactory->reject("Internet Explorer 10 and less is not supported",200);
    }
    else
      $GLOBALS["isIE11"] = (bool) strpos($_SERVER["HTTP_USER_AGENT"], "Trident");

    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
