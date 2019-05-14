<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

require __DIR__."/../../config.php";

$paths = [
  ".",
  \Config\APP_ROOT."/src",
];

set_include_path(implode(PATH_SEPARATOR,$paths));
ini_set("display_errors", "1");
ini_set("log_errors", "0");

require "require.php";

global $rdb;

$rdb = new Jaypha\MySQLiExt(
  $GLOBALS["DB_HOST"],
  $GLOBALS["DB_USER"],
  $GLOBALS["DB_PASSWD"],
  $GLOBALS["DB_DBNAME"]
);

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
