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
  }

  function display()
  {
    assert($this->id != null);
    parent::display();

    // Register dialog with the polyfill.
    echo "<script>docReady.then(function(){App.setUpDialog('$this->id')});</script>";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

