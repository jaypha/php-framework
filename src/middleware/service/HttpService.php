<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class HttpService extends Service
{
  function __construct($logger = null)
  { 
    parent::__construct($logger);
  }

  function setErrorResponseFormatter($erf)
  {
    $erf->setLogger($this->logger);
    \setErrorResponseFormatter($erf);
    return $this;
  }

  function setMimeType($mimeType)
  {
    header("Content-Type: $mimeType");
    return $this;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
