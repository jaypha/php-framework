<?php
//----------------------------------------------------------------------------
// HTTP related functions
//----------------------------------------------------------------------------

namespace Jaypha {

//----------------------------------------------------------------------------
// https://tools.ietf.org/html/rfc7233

function parseHttpRangeHeader($header)
{
  if (strpos($header, "=") == false)
    throw new \Exception("Header invalid");

  $retVal = [];
  // Separate out the 'bytes='
  list($unit, $value) = explode('=', $header, 2);
  if (strlen($value) == 0)
    throw new \Exception("Header invalid", 400);
  $retVal["unit"] = $unit;
  if ($unit == "bytes")
  {
    $retVal["rangeSet"] = [];
    $ranges = explode(",", $value);
    foreach ($ranges as $range)
    {
      $vals = explode("-", $range);
      if (count($vals) != 2)
        throw new \Exception("Header invalid", 400);
      if ($vals[0] == "" && $vals[1] == "")
        throw new \Exception("Header invalid", 400);
      if ($vals[0] != "" && !ctype_digit($vals[0]))
        throw new \Exception("Header invalid", 400);
      if ($vals[1] != "" && !ctype_digit($vals[1]))
        throw new \Exception("Header invalid", 400);
      if ($vals[0] && $vals[1] && $vals[0] > $vals[1])
        throw new \Exception("Header invalid", 400);
      $retVal["rangeSet"][] = $vals;
    }
  }
  else
  {
    $retVal["rangeSet"] = $value;
  }

  return $retVal;
}

//----------------------------------------------------------------------------
// Returns an offest and a count.

function interperetByteRanges($ranges, $size)
{
  $retVal = [];

  foreach ($ranges as $range)
  {
    $v = [];

    if ($range[0] == "") // offset from rear
    {
      if ($range[1] == 0)
        throw new \Exception("Byte range set is unsatisfiable", 416);
      $v[0] = $size-$range[1];
      if ($v[0] < 0)
        $v[0] = 0;
      $v[1] = $size-$v[0];
    }
    else
    {
      if ($range[0] >= $size)
        throw new \Exception("Byte range set is unsatisfiable", 416);
      $v[0] = (int) $range[0];
      if ($range[1] == "" || $range[1] >= $size)
        $v[1] = $size-$v[0];
      else
        $v[1] = $range[1]+1 - $v[0]; // End byte is inclusive
    }

    $retVal[] = $v;
  }
  return $retVal;
}

}

//----------------------------------------------------------------------------
// Some HTTP response functions that shoudl be a part of PHP proper.

namespace {

function http_response_message($message)
{
  $code = http_response_code();
  $version = $_SERVER["SERVER_PROTOCOL"];
  header("$version $code $message");
}

function http_response($code,$message)
{
  $version = $_SERVER["SERVER_PROTOCOL"];
  header("$version $code $message");
}

}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
