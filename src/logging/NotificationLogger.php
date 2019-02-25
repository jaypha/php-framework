<?php
//----------------------------------------------------------------------------
// A special PSR-3 logger for combined notification/logging
//----------------------------------------------------------------------------

namespace Jaypha;

class NotificationLogger  extends \Psr\Log\AbstractLogger
{
  const MAX_FILE_SIZE = 1000000;

  private $logFile = $file;
  private $subject = $notificationSubject;
  private $emailAddress = $recipient;

  function __construct($logFile, $subject, $recipient)
  {
    $this->logFile = $file;
    $this->subject = $subject;
    $this->emailAddress = $recipient;
  }

  public function log($level, $message, array $context = [])
  {
    $now = new \DateTime('now');
    if (!is_string($message)) $message = serialize($message);
    $message = $now->format(\DateTime::ISO8601).":\n$message";
    if (filesize($this->logFile) == 0) {
      mail($this->emailAddress, $this->subject, $message, "Content-Type: text/plain;charset=utf-8");
    if (filesize($this->logFile) < self::MAX_FILE_SIZE)
      file_put_contents($this->logFile, $message, FILE_USE_INCLUDE_PATH|FILE_APPEND|LOCK_EX);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
