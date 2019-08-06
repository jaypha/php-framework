<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class UseMysql implements Middleware
{
  public function handle(
    $input,
    Service $service
  )
  {
    global $rdb;

    $rdb = new \Jaypha\MySQLiExt
    (
      \Config\MYSQL_HOST,
      \Config\MYSQL_USER,
      \Config\MYSQL_PASSWORD,
      \Config\MYSQL_DATABASE
    );
    $rdb->q("start transaction");
    try {
      $output = $service->next($input);
    } catch (Throwable $t)
    {
      $rdb->q("rollback");
      throw $t;
    }

    $rdb->q("commit");
    return $output;
  }
}
  
//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

