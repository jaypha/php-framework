<?php
//----------------------------------------------------------------------------
// PSR-3 based logger that logs to output.
//----------------------------------------------------------------------------

namespace Jaypha;

class EchoLogger extends \Psr\Log\AbstractLogger
{
  public $logs;

  public function log($level, $message, array $context = [])
  {
    echo "Log ($level): $message\n";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
