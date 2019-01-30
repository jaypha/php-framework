<?php
//----------------------------------------------------------------------------
// PSR-3 based logger that does nothing.
//----------------------------------------------------------------------------

namespace Jaypha;

class NullLogger extends \Psr\Log\AbstractLogger
{
  public function log($level, $message, array $context = []) {}
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
