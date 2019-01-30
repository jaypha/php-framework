<?php
//----------------------------------------------------------------------------
// PSR-3 based logger that logs to STDOUT.
//----------------------------------------------------------------------------

namespace Jaypha;

class StdoutLogger extends \Psr\Log\AbstractLogger
{
  public $logs;

  public function log($level, $message, array $context = [])
  {
    file_put_contents("php://stdout", "Log ($level): $message\n");
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
