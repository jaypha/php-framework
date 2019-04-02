<?php
//----------------------------------------------------------------------------
// Widget for text, password inputs
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class TextAreaWidget extends Widget
{
  public $value;

  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "textarea";
  }

  protected function displayInner() { echo $this->value; }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
