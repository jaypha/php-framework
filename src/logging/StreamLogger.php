<?php
//----------------------------------------------------------------------------
// PSR-3 based logger that logs to a provided stream
//----------------------------------------------------------------------------

namespace Jaypha;

class StreamLogger extends \Psr\Log\AbstractLogger
{
  protected $stream;

  function __construct($stream) { $this->stream = $stream; }

  public function log($level, $message, array $context = [])
  {
    fwrite($this->stream, "Log ($level): $message\n");
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
