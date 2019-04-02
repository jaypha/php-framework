<?php
//----------------------------------------------------------------------------
// Startup for console scripts.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

const IS_CONSOLE = true;

$_SERVER["DOCUMENT_ROOT"] = ".";
$_SERVER["HTTP_HOST"] = "";
$_SERVER["REQUEST_METHOD"] = "CONSOLE";
$_SERVER["REQUEST_URI"] = $_SERVER["SCRIPT_NAME"];

require \Config\APP_ROOT."/vendor/autoload.php";

if (isset($altConfig))
  require \Config\APP_ROOT."/$altConfig";
else
  require \Config\APP_ROOT."/config.php";

require "require.php";
require "console-functions.php";

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
