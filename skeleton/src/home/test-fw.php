<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Skeleton;

use Jaypha\Middleware as MW;

function getDocument($service)
{
  addStdHtmlBundle($service);
  return $service->add(
    function($input, $service)
    {
      $document = new MainDocument();
      $document->title = "Test FW";
      $document->content->add("<h1>Test FW OK</h1>");
      return $document;
    }
  );
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
