<?php
//----------------------------------------------------------------------------
// Special Service for console applications
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ConsoleService extends Service
{
  function run($middleware = null)
  {
    if ($middleware) $this->add($middleware);
    $input = isset($_SERVER['argv']) ? array_slice($_SERVER['argv'], 1) : [];
    $output = $this->next($input);
    echo $output;
  }

  function setResponseFactory(ResponseFactory $responseFactory)
  {
    $this->responseFactory = $responseFactory;
    return $this;
  }

  function reject($message, $code = 200)
  {
    if ($this->responseFactory)
      return $this->responseFactory->reject($message, $code);
  }

  function gracefulExit($code = 500)
  {
    if ($this->responseFactory)
      $this->responseFactory->gracefulExit($code);
    exit;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
