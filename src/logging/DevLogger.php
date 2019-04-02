<?php
//----------------------------------------------------------------------------
// Logger to use when developing.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class DevLogger implements \Psr\Log\LoggerInterface
{
  //-------------------------------------------------------

  function __construct()
  {
  }

  //-------------------------------------------------------

  public function emergency($message, array $context = [])
  {}

  //-------------------------------------------------------

  public function alert($message, array $context = [])
  {}

  //-------------------------------------------------------

  public function critical($message, array $context = [])
  {
    while (ob_get_level() != 0) ob_end_clean();
    echo "<pre>\n$message\n</pre>\n";
    exit(1);
  }

  //-------------------------------------------------------

  public function error($message, array $context = [])
  {
    while (ob_get_level() != 0) ob_end_clean();
    echo "<pre>\n$message\n</pre>\n";
    exit(1);
  }

  //-------------------------------------------------------

  public function warning($message, array $context = [])
  {
    while (ob_get_level() != 0) ob_end_clean();
    echo "<pre>\n$message\n</pre>\n";
    exit(1);
  }

  //-------------------------------------------------------

  public function notice($message, array $context = [])
  {
    echo "<pre>\n$message\n</pre>\n";
  }

  //-------------------------------------------------------

  public function info($message, array $context = [])
  {
    echo "<pre>\n$message\n</pre>\n";
  }

  //-------------------------------------------------------

  public function debug($message, array $context = [])
  {
    echo "<pre>\n$message\n</pre>\n";
  }

  //-------------------------------------------------------

  public function log($level, $message, array $context = [])
  {
    switch ($level)
    {
      case \Psr\Log\LogLevel::EMERGENCY:
        $this->emergency($message, $context);
        break;
      case \Psr\Log\LogLevel::ALERT:
        $this->alert($message, $context);
        break;
      case \Psr\Log\LogLevel::CRITICAL:
        $this->critical($message, $context);
        break;
      case \Psr\Log\LogLevel::ERROR:
        $this->error($message, $context);
        break;
      case \Psr\Log\LogLevel::WARNING:
        $this->warning($message, $context);
        break;
      case \Psr\Log\LogLevel::NOTICE:
        $this->notice($message, $context);
        break;
      case \Psr\Log\LogLevel::INFO:
        $this->info($message, $context);
        break;
      case \Psr\Log\LogLevel::DEBUG:
        $this->debug($message, $context);
        break;
    }
  }

  //-------------------------------------------------------
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
