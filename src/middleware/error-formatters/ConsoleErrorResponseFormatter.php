<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class ConsoleErrorResponseFormatter extends ErrorResponseFormatter
{
  function gracefulExit($code = 500)
  {
    fwrite(STDERR, "Error: $code\n");
    return null;
  }

  function getRejectResponse($code, $message = null)
  {
    return "Rejected: ($code) $message, \n";
  }

  function getErrorResponse($code, $message = null)
  {
    return "Error: ($code) $message, \n";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
