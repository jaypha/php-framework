<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Dialog extends Element
{
  public $jsEventListeners = [];

  function __construct($id)
  {
    assert($id != "");
    parent::__construct("dialog");
    $this->id = $id;
    $s = $this->addScript();
    $s->add("docReady.then(function(){App.setUpDialog('$id')});");
  }

  function getShowModalJs()
  {
    return "document.getElementById('$this->id').showModal()";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

