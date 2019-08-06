<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class TestService extends \Jaypha\Middleware\Service
{
  function __construct(iterable $input)
  { 
    parent::__construct();
    $this->originalInput = $input;
  }

  function run($middleware = null)
  {
    if ($middleware) $this->add($middleware);
    return $this->next($this->originalInput);
  }

  function setErrorResponseFormatter($erf) { return $this; }
  function setMimeType($mimeType) { return $this; }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
