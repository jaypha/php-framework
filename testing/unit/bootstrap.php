<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

require __DIR__."/../config-unit.php";

$paths = [
  ".",
  \Config\APP_ROOT."/src",
];

set_include_path(implode(PATH_SEPARATOR,$paths));
ini_set("display_errors", "1");
ini_set("log_errors", "0");

require "require.php";

use Jaypha\MySQLiExt;

global $rdb;

$rdb = new MySQLiExt(
  \Config\Mysql::Host,
  \Config\Mysql::User,
  \Config\Mysql::Password,
  \Config\Mysql::Database
);

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
