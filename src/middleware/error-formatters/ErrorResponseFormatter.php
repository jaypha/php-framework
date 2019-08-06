<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

abstract class ErrorResponseFormatter
{
  protected $logger;

  function __construct($logger = null) { $this->logger = $logger; }
  function getLogger() { return $this->logger; }
  function setLogger($logger) { $this->logger = $logger; }
  
  abstract function gracefulExit($code = 500);
  abstract function getRejectResponse($code, $message = null);
  abstract function getErrorResponse($code, $message = null);
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
