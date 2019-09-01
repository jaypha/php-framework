<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ImageOutput implements Middleware
{
  function __construct($imgType)
  {
    $this->imgType = $imgType;
  }

  public function handle($input, Service $service)
  {
    $output = $service->next($input);

    $service->setMimeType("image/$this->imgType");

    return $output;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

