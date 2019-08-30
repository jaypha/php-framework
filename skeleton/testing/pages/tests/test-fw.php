<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------


namespace Skeleton;

require "../.startup.php";
require "home/test-fw.php";

$service->add(new \Jaypha\ValidateHtmlDocument("tests/test-fw"));
getDocument($service)
->run();

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
