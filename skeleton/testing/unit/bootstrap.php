<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

require __DIR__."/../../paths.php";

ini_set("display_errors", "1");
ini_set("log_errors", "0");

require \APP_ROOT."/config.php";

require "require.php";

use Jaypha\MySQLiExt;

global $rdb;

$rdb = new MySQLiExt(
  $GLOBALS["DB_HOST"],
  $GLOBALS["DB_USER"],
  $GLOBALS["DB_PASSWD"],
  $GLOBALS["DB_DBNAME"]
);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
