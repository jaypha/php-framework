<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

abstract class CheckableControl extends Control
{
  function __construct($name)
  {
    $this->validator = new \Jaypha\ExtractText($name);
    parent::__construct($name);
    $this->tagName = "input";
    $this->value = 1;
  }

  //-------------------------------------------------------

  function asBoolean($isBool = true)
  {
    if ($isBool)
      $this->validator = new \Jaypha\ExtractBoolean($this->name);
    else
      $this->validator = new \Jaypha\ExtractText($this->name);
  }

  //-------------------------------------------------------

  function display()
  {
    if (
      $this->form !== null &&
      array_key_exists($this->name, $this->form->values)
    )
      $this->checked = ($this->value == $this->form->values[$this->name]);
    parent::display();
  }

  //-------------------------------------------------------

  function __get($p)
  {
    switch($p)
    {
      case "checked":
        return isset($this->attributes[$p]);
      default:
        return parent::__get($p);
    }
  }

  //-------------------------------------------------------

  function __set($p, $v)
  {
    switch($p)
    {
      case "checked":
        if ($v)
          $this->attributes[$p] = true;
        else
          unset($this->attributes[$p]);
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
