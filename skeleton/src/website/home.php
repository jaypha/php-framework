<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

require "startup/startup.php";

use Jaypha\Middleware as MW;
use Jaypha\Streams\StringInputStream;

$service
->setResponseFactory(new MW\HtmlResponseFactory())
->run(
  function($input, MW\Service $service)
  {
    $doc = new DocumentBase();
    $doc->content->setTemplate("website/home.tpl");

    return new StringInputStream($doc);
  }
);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
