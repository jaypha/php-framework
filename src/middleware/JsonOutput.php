<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class JsonOutput implements Middleware
{
  public function handle($input, Service $service)
  {
    $service->setMimeType("application/json");

    $output = $service->next($input);

    if (!is_string($output))
      $output = json_encode($output);
    return $output;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

