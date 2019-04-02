<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

require __DIR__."/../paths.php";

ini_set("display_errors", "1");
ini_set("log_errors", "0");

require \APP_ROOT."/config.php";

require "require.php";

use Jaypha\MySQLiExt;

global $rdb;

$rdb = new MySQLiExt(
  \Config\MYSQL_HOST,
  \Config\MYSQL_USER,
  \Config\MYSQL_PASSWORD,
  \Config\MYSQL_DATABASE
);

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
