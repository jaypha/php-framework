<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class JsonResponseFactory implements ResponseFactory
{
  function mimeType() { return "application/json"; }
  function gracefulExit($code)
  {
    http_response_code($code);
    echo json_encode([ "success" => false, "message" => "error" ]);
  }

  function reject($message, $code)
  {
    http_response_code($code);
    return json_encode([ "success" => false, "message" => $message ]);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
