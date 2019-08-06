<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class HtmlErrorResponseFormatter extends ErrorResponseFormatter
{
  public $fileDir;

  function __construct($fileDir, $logger =  null)
  {
    parent::__construct($logger);
    $this->fileDir = $fileDir;
  }

  function gracefulExit($code = 500)
  {
    http_response_code($code);
    readfile("$this->fileDir/$code.html", true);
  }

  function getRejectResponse($code, $message = null)
  {
    return getfilecontents("$this->fileDir/$code.html", true);
  }

  function getErrorResponse($code, $message = null)
  {
    return getfilecontents("$this->fileDir/$code.html", true);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
