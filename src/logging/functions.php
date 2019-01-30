<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
// Some functions for logging that do not involve classes.
//----------------------------------------------------------------------------

function console($message)
{
  file_put_contents("php://stdout", $message."\n");
}

function browserConsole($message)
{
  return "<script>console.log('$message');</script>";
}

function debugLog($message)
{
  if (\Config\Logging::DebugLog)
  {
    $now = now();
    if (is_array($message)) $message = serialize($message);
    file_put_contents(\Config\Logging::DebugLog, $now->format(\DateTime::ISO8601).": $message\n", FILE_USE_INCLUDE_PATH|FILE_APPEND|LOCK_EX);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
