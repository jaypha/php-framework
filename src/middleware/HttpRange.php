<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------


class HttpRange implements Middleware
{
  public function handle(
    $input,
    Service $service
  )
  {
    if (array_key_exists("HTTP_RANGE",$_SERVER))
    {
      $ranges = \PHS\parseHttpRangeHeader($_SERVER["HTTP_RANGE"]);
      if ($ranges["unit"] != "bytes")
        return new \Exception("Non byte range units not supported", 416);
      $vals = \PHS\interperetByteRanges($ranges["rangeSet"], $fileSize);
      if (count($vals) > 1)
        return new \Exception("Multipart ranges not supported", 416);
      $start = $vals[0][0];
      $end = $start + $vals[0][1] - 1;
      $output = $service->next($input);
      header("Content-Range: bytes $start-$end/$fileSize");
      $output = new SliceInputStream($output, $start, $end);
    }
    else
      $output = $service->next($input);

    return $output;
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

