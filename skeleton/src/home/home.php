<?php
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
      $document->title = "Home";
      $document->setTemplate("home/home.tpl");
      return $document;
    }
  );
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
