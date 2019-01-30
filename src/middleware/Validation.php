<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

use PHS\Validator;

class Validation implements Middleware
{
  protected $validator;

  function __construct($rules)
  {
    if ($rules instanceof Validator)
      $this->validator = $rules;
    else
      $this->validator = new Validator($rules);
  }

  function handle($input, Service $service)
  {
    $result = $this->validator->validate($input);
    if ($result["success"])
      return $service->next($result["values"]);
    else
      return $service->responseFactory->reject(implode("\n",$result["failures"]),400);
  }          
}

class ValidateId extends Validation
{
  function __construct($idName, $required = true)
  {
    parent::__construct([$idName => ["type" => "id", "required" => $required]]);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
