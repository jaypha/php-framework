<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class PdfOutput implements Middleware
{
  function __construct()
  {
  }

  public function handle($input, Service $service)
  {
    $output = $service->next($input);

    if ($output instanceof \Jaypha\PdfDocument)
    {
      if ($output->filename)
        header("Content-Disposition: inline; filename=\"$output->filename\"");

      $output = $output->__toString();
    }
    else if (is_object($output))
      $output = $output->__toString();

    assert(is_string($output));

    $service->setMimeType("application/pdf");

    header("Content-Length: ".strlen($output));

    return $output;
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "filename":
        throw new \Jaypha\DeprecatedException("PdfOutput::filename is deprecated");
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

