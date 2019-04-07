<?php
//----------------------------------------------------------------------------
// JSON responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class CsvResponseFactory implements ResponseFactory
{
  function mimeType() { return "application/csv"; }
  function gracefulExit($code)
  {
    http_response_code($code);
    return null;
  }

  function reject($message, $code)
  {
    http_response_code($code);
    return null;
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
