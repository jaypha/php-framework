<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class JayphaEditable extends Widget
{
  public $value = null;

  function __construct($name, $form=null)
  {
    parent::__construct($name);
    $this->tagName = "jaypha-editable";
  }

  function display()
  {
    $this->add($this->value);
    parent::display();
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
