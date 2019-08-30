<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class Service
{
  private $mimeType = "text/html";

  private $stack = [];
  private $stackIdx = 0;
  protected $originalInput;

  function __construct()
  {
    $this->setInput($_REQUEST);
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

  function setInput($input)
  {
    $this->originalInput = $input;
  }

  function run($middleware = null)
  {
    if ($middleware) $this->add($middleware);
    return $this->next($this->originalInput);
  }

  function output()
  {
    $output = $this->run();
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

    throw new \LogicException("Middleware stack is exhausted");
  }

  function setMimeType($mimeType)
  {
    $this->mimeType = $mimeType;
    header("Content-Type: $mimeType");
    return $this;
  }

  function getMimeType()
  {
    return $this->mimeType;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
