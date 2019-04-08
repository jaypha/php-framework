<?php
//----------------------------------------------------------------------------
// Main logger utilising the PSR-3 interface.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class MainLogger implements \Psr\Log\LoggerInterface
{
  //-------------------------------------------------------

  public function emergency($message, array $context = [])
  {}

  //-------------------------------------------------------

  public function alert($message, array $context = [])
  {}

  //-------------------------------------------------------

  public function critical($message, array $context = [])
  {
    if (\Config\Logging::ErrorEmail)
      \mail(\Config\Logging::ErrorEmail, "Critical Error", $message);
    $this->logToErrorLog($message);
  }

  //-------------------------------------------------------

  public function error($message, array $context = [])
  {
    if (\Config\Logging::ErrorEmail)
      \mail(\Config\Logging::ErrorEmail, "Non-Critical Error", $message);
    $this->logToErrorLog($message);
  }

  //-------------------------------------------------------

  public function warning($message, array $context = [])
  {
    $this->logToErrorLog($message);
  }

  //-------------------------------------------------------

  public function notice($message, array $context = [])
  {
    $this->logToErrorLog($message);
  }

  //-------------------------------------------------------

  public function info($message, array $context = [])
  {
    $this->logToErrorLog($message);
  }

  //-------------------------------------------------------

  public function debug($message, array $context = [])
  {
    $this->logToFile($message, \Config\Logging::DebugLog);
  }

  //-------------------------------------------------------

  protected function logToErrorLog($message)
  {
  	if (ini_get("log_errors") == "1")
  	{
      $now = new \DateTime('now', getTimezone());
      if (!is_string($message)) $message = serialize($message);
      error_log($now->format(\DateTime::ISO8601).": $message\n");
    }
  }

  protected function logToFile($message, $file)
  {
    if ($file)
    {
      $now = new \DateTime('now', getTimezone());
      if (!is_string($message)) $message = serialize($message);
      file_put_contents($file, $now->format(\DateTime::ISO8601).": $message\n", FILE_USE_INCLUDE_PATH|FILE_APPEND|LOCK_EX);
    }
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
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
