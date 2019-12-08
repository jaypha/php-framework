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

    if ($output instanceof \Jaypha\CsvDocument)
    {
      if ($output->filename)
        header("Content-Disposition: inline; filename=\"$output->filename\"");

      $output = $output->__toString();
    }
    else if (is_array($output))
      $output = \Jaypha\csv_encode($this->data);
    assert(is_string($output));

    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-Length: ".strlen($output));

    $service->setMimeType("application/csv");
    return $output;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

