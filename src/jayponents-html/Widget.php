<?php
//----------------------------------------------------------------------------
// Base class for form widgets
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Widget extends Element
{
  public $form;

  function __construct($name, $form=null)
  {
    parent::__construct();
    $this->form = $form;
    $this->name = $name;
    $this->cssClasses[] = "widget";
  }

  //-------------------------------------------------------

  function display()
  {
    if (
      $this->value === null &&
      $this->form !== null &&
      array_key_exists($this->name, $this->form->values)
    )
      $this->value = $this->form->values[$this->name];

    parent::display();
  }

  //-------------------------------------------------------

  function __get($p)
  {
    switch ($p) {
      case "name":
        return $this->attributes[$p];
      default:
        return parent::__get($p);
    }
  }

  //-------------------------------------------------------

  function __set($p, $v)
  {
    switch ($p) {
      case "name":
        $this->attributes[$p] = $v;
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
