<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class NullErrorResponseFormatter extends ErrorResponseFormatter
{
  function gracefulExit($code)
  {
    http_response_code($code);
  }

  function getRejectResponse($code, $message = null)
  {
    return "";
  }

  function getErrorResponse($code, $message = null)
  {
    return "";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
