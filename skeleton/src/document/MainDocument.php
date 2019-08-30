<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use Jaypha\Jayponents\Component;

class MainDocument extends Jaypha\Jayponents\Html\Document
{
  public $content;

  function __construct($pageId = null)
  {
    parent::__construct($pageId);
    assert((function($doc){if (defined("SHOW_CAUTION"))$doc->body->cssClasses[]="show-caution";return true;})($this));

    if (MW\DetectUserAgent::isIE11())
    {
      $this->head->addScriptTag("/assets/polyfills/polyfills.ie.js");
      $this->head->addStylesheet("/assets/polyfills/polyfills.ie.css");
    }
    else
    {
      $this->head->addScriptTag("/assets/polyfills/polyfills.js");
      $this->head->addStylesheet("/assets/polyfills/polyfills.css");
    }
      
    $this->head->add(file_get_contents(__DIR__."/head-extra.html"));

    $this->content = new Html\Element("main");
    if (MW\DetectUserAgent::isIE11())
    {
      $this->content->tagName = "div";
      $this->content->cssClasses[] = "main-element";
    }

    $this->body->setTemplate("document/MainDocument.tpl");
    $this->body->set("content", $this->content);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
