<?php
//----------------------------------------------------------------------------
// Text based PSR-3 logger
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class TextLogger extends \Psr\Log\AbstractLogger
{
  public $logs;

  function __construct()

  public function log($level, $message, array $context = [])
  {
    $this->logs[] = $message;
  }

  public function extract()
  {
    return implode("\n", $this->logs);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
