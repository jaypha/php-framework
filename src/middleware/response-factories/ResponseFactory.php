<?php
//----------------------------------------------------------------------------
// Stock repsonses that will be different depeding on the context
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

interface ResponseFactory
{
  function mimeType();
  function gracefulExit($code);
  function reject($mesasge, $code);
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
