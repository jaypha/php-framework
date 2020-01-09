<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

use Latte\Engine;
use Latte\Loaders\FileLoader;
use Jaypha\Jayponents\Component;
use Jaypha\Jayponents\Latte\LatteEngineAdaptor;

class ExtractJsonInput implements Middleware
{
  public function handle($input, Service $service)
  {
    $requestBody = file_get_contents("php://input");
    $input = json_decode($requestBody, true);
    if (json_last_error() !== JSON_ERROR_NONE)
      return null; // TODO use reject method

    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
