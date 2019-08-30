<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Jaypha\Jayponents\Html;

require __DIR__."/.startup.php";
require __DIR__."/the-form.php";

\setErrorHandlers();
\setLogger(new StreamLogger(STDERR));
$service = new MW\Service();
$service->add(function($input, $service) {
  debug("pre world");
  return $service->next($input);
});
$service->push(function($input, $service) {
  debug("post world");
  return $service->next($input);
});
$service->add(
  function($input, $service) {
    $form = getTheForm();
    $form->values = [ "username" => "bill" ];
    return $form;
  }
)
->output();

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
