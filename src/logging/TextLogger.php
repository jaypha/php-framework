<?php
//----------------------------------------------------------------------------
// Text based PSR-3 logger
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------


namespace PHS;

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
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
