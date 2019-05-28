<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
// TODO setting value for Bool widgets doesn't work.
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class BooleanWidget extends Widget
{
  public $value = null;

  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "input";
    $this->attributes["type"]="checkbox";
    $this->attributes["value"]="1";
  }

  function display()
  {
    if ($this->value !== null)
      $this->attributes["selected"] = (bool)$this->value;
    parent::display();
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
