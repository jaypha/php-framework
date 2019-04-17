<?php
//----------------------------------------------------------------------------
// JSON responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class JsonResponseFactory implements ResponseFactory
{
  function mimeType() { return "application/json"; }
  function gracefulExit($code)
  {
    echo json_encode([ "success" => false, "message" => "error" ]);
  }

  function reject($message, $code)
  {
    return json_encode([ "success" => false, "message" => $message ]);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
