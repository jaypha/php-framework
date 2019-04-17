<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;
use Jaypha\Streams\StringInputStream;

class CsvOutput implements ResponseFactory, Middleware
{
  //function mimeType() { return "text/plain"; }
  function mimeType() { return "application/csv"; }

  function gracefulExit($code)
  {
    return null;
  }

  function reject($message, $code)
  {
    return null;
  }

  public function handle($input, Service $service)
  {
    $service->setResponseFactory($this);
    $output = $service->next($input);

    if ($output instanceof \Jaypha\CsvDocument)
    {
      if ($output->filename)
        header("Content-Disposition: attachment; filename=\"$output->filename\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      return new StringInputStream(\Jaypha\csv_encode($output->data));
    }
    else
    {
      assert(is_string($output) || $output instanceof InputStream);
      return $output;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

/*
function csvSend($data, $filename = null)
{
  //header("Content-type: text/plain");
  header("Content-type: application/csv");
  if ($filename)
    header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Pragma: no-cache");
  header("Expires: 0");

  echo csv_encode($data);
}
*/
