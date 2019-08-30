<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------


namespace HPT;

require ".startup.php";
require "home/home.php";

$service->add(new \Jaypha\ValidateHtmlDocument("home"));
getDocument($service)
->run();

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
