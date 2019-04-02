<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use Jaypha\Jayponents\Component;

class DocumentBase extends Jaypha\Jayponents\Html\Document
{
  public $content;

  function __construct($pageId = null)
  {
    parent::__construct($pageId);
    assert((function($doc){if (defined("SHOW_CAUTION"))$doc->body->cssClasses[]="show-caution";return true;})($this));

    if ($GLOBALS["isIE11"])
      $script = $this->head->addScriptTag("/assets/js/polyfills.ie.js");
      
    $script = $this->head->addScriptTag();
    $script->add(file_get_contents(__DIR__."/script.tpl"));

    $this->content = new Component();
    $this->body->set("content", $this->content);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
