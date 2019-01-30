<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class CmdLineParser implements Middleware
{
  protected $validator;
  protected $parser;

  function __construct($options)
  {
    $this->parser = new \Nette\CommandLine\Parser($options);
  }

  function handle($input, Service $service)
  {
    $args = $this->parser->parse();
    return $service->next($args);
  }          
}


//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
