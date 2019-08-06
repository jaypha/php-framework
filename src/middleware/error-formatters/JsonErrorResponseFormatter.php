<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class JsonErrorResponseFormatter extends ErrorResponseFormatter
{
  function gracefulExit($code = 500)
  {
    http_response_code($code);
    echo json_encode([ "success" => false, "message" => "An error has occured.", "code" => $code ]);
  }

  function getRejectResponse($code, $message = null)
  {
    return [ "success" => false, "message" => $message, "code" => $code ];
  }

  function getErrorResponse($code, $message = null)
  {
    return [ "success" => false, "message" => $message, "code" => $code ];
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
