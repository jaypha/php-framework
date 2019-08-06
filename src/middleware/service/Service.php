<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

use Jaypha\NullLogger;
use \Psr\Log\LoggerInterface;

abstract class Service
{
  private $stack = [];
  private $stackIdx = 0;
  protected $originalInput;

  function __construct($logger = null)
  {
    if ($logger) $this->logger = $logger;
    else $this->logger = new NullLogger();
    assert ($this->logger instanceof LoggerInterface);
  }

  function getLogger() { return $this->logger; }
  function setLogger($logger)
  {
    assert ($logger instanceof LoggerInterface);
    $this->logger = $logger;
    $erf = \getErrorResponseFormatter();
    if ($erf) $erf->setLogger($this->logger);
    return $this;
  }

  function add($middleware)
  {
    if (is_array($middleware))
      $this->stack = array_merge($this->stack, $middleware);
    else
      $this->stack[] = $middleware;
    return $this;
  }

  function push($middleware)
  {
    if (is_array($middleware))
      $this->stack = array_merge($middleware, $this->stack);
    else
      array_unshift($this->stack, $middleware);
    return $this;
  }

  function run($middleware = null)
  {
    if ($middleware) $this->add($middleware);
    $input = $_REQUEST;
    $this->originalInput = $input;
    return $this->next($input);
  }

  function output($middleware = null)
  {
    $output = $this->run($middleware);
    echo $output;
  }

  function next($input)
  {
    if (array_key_exists($this->stackIdx,$this->stack))
    {
      $current = $this->stack[$this->stackIdx++];
      if (is_callable($current))
        return $current($input, $this);
      else
        return $current->handle($input, $this);
    }

    return null;
  }

  abstract function setErrorResponseFormatter($erf);
  abstract function setMimeType($mimeType);
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
