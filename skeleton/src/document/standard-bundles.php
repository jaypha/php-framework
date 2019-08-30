<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace HPT;

use Jaypha\Middleware as MW;

function htmlGraceful($code)
{
  readfile("document/$code.html", true);
}

function addStdHtmlBundle($service)
{
  \setGracefulExitOutput("\HPT\htmlGraceful");
  $service->add(new MW\UseLatteEngine());
}

//----------------------------------------------------------------------------

function jsonGraceful($code)
{
  echo json_encode([ "success" => false, "message" => "An error has occured.", "code" => $code ]);
}

function addStdJsonBundle($service)
{
  \setGracefulExitOutput("\HPT\jsonGraceful");
  $service->add(new MW\JsonOutput());
}

function addStdPdfBundle($service)
{
}

function addStdCsvBundle($service)
{
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
