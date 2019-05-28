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
    return json_encode([ "success" => false, "message" => "error" ]);
  }

  function reject($message, $code)
  {
    return json_encode([ "success" => false, "message" => $message ]);
  }
}

//----------------------------------------------------------------------------

class JsonOutput extends JsonResponseFactory implements Middleware
{
  public function handle($input, Service $service)
  {
    $service->setResponseFactory($this);
    $output = $service->next($input);

    if (is_array($output))
    {
      $output["success"] = true;
      return new StringInputStream(json_encode($output->data));
    }
    else
    {
      assert(is_string($output) || $output instanceof InputStream);
      return $output;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
