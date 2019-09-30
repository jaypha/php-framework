<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class PdfOutput implements Middleware
{
  public $filename;

  function __construct()
  {
  }

  public function handle($input, Service $service)
  {
    $output = $service->next($input);

    if (!is_string($output))
      $output = $output->__toString();
    $service->setMimeType("application/pdf");

    header("Content-Length: ".strlen($output));

    if ($this->filename)
      header("Content-disposition: inline; filename=\"$this->filename\"");

    return $output;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

