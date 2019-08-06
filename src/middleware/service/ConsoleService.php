<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ConsoleService extends Service
{
  function __construct($logger = null)
  { 
    parent::__construct($logger);
    \setErrorResponseFormatter(new \Jaypha\ConsoleErrorResponseFormatter($this->logger));
  }

  function run($middleware = null)
  {
    if ($middleware) $this->add($middleware);
    $input = array_slice($GLOBALS["argv"], 1);
    $this->originalInput = $input;
    return $this->next($input);
  }

  function setErrorResponseFormatter($erf)
  {
    return $this;
  }

  function setMimeType($mimeType)
  {
    return $this;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
