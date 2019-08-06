<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;
use Jaypha\Streams\StringInputStream;

class CsvOutput implements Middleware
{
  public function handle($input, Service $service)
  {
    $output = $service->next($input);

    if ($output instanceof CsvDocument)
    {
      if ($output->filename)
        header("Content-Disposition: attachment; filename=\"$output->filename\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $output = $output->__toString();
    }
    assert(is_string($output));
    $service->setMimeType("application/csv");
    return $output;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

