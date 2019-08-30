<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Jaypha\Jayponents\Html;

use Jaypha\Middleware as MW;

require __DIR__."/.startup.php";
require __DIR__."/the-form.php";

//set_exception_handler("errorWithDetails");
//set_error_handler("phpError");

setLogger(new StreamLogger(STDERR));
$service = new MW\Service();
$service->add(new MW\UseSimpleCmdLineParser());
$service->add(new MW\JsonOutput());
$service->add(function($input, $service) {
  $form = getTheForm();
  $r = $form->extract($input);
  $result = new ValidationResult($r);
  if ($result->success)
    return [ "success" => true, "values" => $result->values ];
  else
    return [ "success" => false, "message" => $result->getFailuresAsString() ];
});
$service->output();

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
