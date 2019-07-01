<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
// TODO setting value for Bool widgets doesn't work.
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class BooleanWidget extends Widget
{
  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "input";
    $this->attributes["type"]="checkbox";
    $this->attributes["value"]="on";
  }

  function display()
  {
    if (
      !array_key_exists("selected", $this->attributes) &&
      $this->form !== null &&
      array_key_exists($this->name, $this->form->values)
    )
      $this->value = $this->form->values[$this->name];

    parent::display();
  }

  function __get($p)
  {
    switch ($p)
    {
      case "value":
        return isset($this->attributes["checked"]);
      default:
        return parent::__get($p);
        break;
    }
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "value":
        $this->attributes["checked"] = (bool)$v;
        break;
      default:
        parent::__set($p, $v);
        break;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
