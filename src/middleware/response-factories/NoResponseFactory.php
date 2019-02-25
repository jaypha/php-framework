<?php
//----------------------------------------------------------------------------
// Bootstrap for requests expecting no return content.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class NoResponseFactory implements ResponseFactory
{
  function __construct() { http_response_code(204); }
  function mimeType() { return "text/plain"; }

  function gracefulExit($code) {}
  function reject($message, $code) {}
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
