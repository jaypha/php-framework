<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

use Jaypha\Middleware as MW;


class JayphaDocument extends Document
{
  public $headScript;
  private $polyfillScript;
  private $polyfillStylesheet;

  //-------------------------------------------------------

  function __construct($pageId = null)
  {
    parent::__construct($pageId);
    $this->polyfillScript = $this->head->addScriptTag();
    $this->polyfillStylesheet = $this->head->addStylesheet(null);
    $this->headScript = $this->head->addScriptTag();
    $this->headScript->add(APP_JS);
    $this->headScript->add(MW\TIMEZONE_JS);
  }

  //-------------------------------------------------------

  function setPolyfill($scriptFile, $stylesheetFile)
  {
    $this->polyfillScript->src = $scriptFile;
    $this->polyfillStylesheet->attributes["href"] = $stylesheetFile;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
