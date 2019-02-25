<?php
//----------------------------------------------------------------------------
// File based PSR-3 logger
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class FileLogger extends \Psr\Log\AbstractLogger
{
  private $logFile;

  function __construct($file)
  {
    $this->logFile = $file;
  }

  public function log($level, $message, array $context = [])
  {
    $now = new \DateTime('now');
    if (!is_string($message)) $message = serialize($message);
    file_put_contents($this->logFile, $now->format(\DateTime::ISO8601).": [$level] $message\n", FILE_USE_INCLUDE_PATH|FILE_APPEND|LOCK_EX);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
