<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

interface Middleware
{
  public function handle(
    $input,
    Service $service
  );
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
