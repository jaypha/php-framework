<?php
//----------------------------------------------------------------------------
// Validates an input value against the ID pattern (all digits). Will add
// a default value if absent and not required.
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ValidateId implements Middleware
{
  private $name, $isRequired;

  function __construct($name, $isRequired)
  {
    $this->name = $name;
    $this->isRequired = $isRequired;
  }

  function setRejectFunction(callable $fn)
  {
  }

  public function handle(
    $input,
    Service $service
  )
  {
    $id = \Jaypha\extractId($input, $this->name, $this->isRequired);
    if ($id === false)
      \gracefulExit(400);
    $input[$this->name] = $id;

    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
