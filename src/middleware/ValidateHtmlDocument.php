<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Jaypha\Middleware as MW;
use KubaWerlos\HtmlValidator\Validator;

class ValidateHtmlDocument implements MW\Middleware
{
  function __construct($pageName) { $this->pageName = $pageName; }
  function handle($input, $service)
  {
    try {
      $document = $service->next($input);
      $html = $document->__toString();
      $validated = Validator::validate($html);
      if (strpos($validated,"error") !== false)
        \getLogger()->info("$this->pageName $validated");
      return $document;
    }
    catch (\Throwable $e)
    {
      \getLogger()->error("$this->pageName failed to run:\n".$e->getMessage());
      return null;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
