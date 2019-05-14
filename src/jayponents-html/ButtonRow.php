<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class ButtonRow extends Element
{
  protected $buttons;

  function __construct()
  {
    parent::__construct("div");
    $this->cssClasses[] = "button-row";
    $this->buttons = new \ArrayObject();
    $this->set("buttons", $this->buttons);
  }

  function addButton($button = null)
  {
    if ($button == null || is_string($button)) $button = new Button($button);
    $this->buttons[] = $button;
    return $button;
  }

  function __get($p)
  {
    switch ($p)
    {
      case "count":
        return count($this->buttons);
    }
  }

  //-------------------------------------------------------

  static function fromDefs(array $defs)
  {
    $buttons = new ButtonRow();
    foreach ($defs as $def)
    {
      switch ($def["type"])
      {
        case "submit":
          $buttons->addButton(Button::submitButton($def["label"], $def["value"])); 
        default:
      }
    }
    return $buttons;
  }

}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
