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
    $this->setInput($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
