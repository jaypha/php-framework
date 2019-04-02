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
    if ($button == null) $button = new Button();
    $this->buttons[] = $button;
    return $button;
  }

/*
  function addSubmitButton($label)
  {
    $button = new Button($label);
    $this->buttons[] = $button;
    $button->type="submit";
    return $button;
  }

  function addLinkButton($label, $link)
  {
    $button = new Button($label);
    $this->buttons[] = $button;
    $button->type="button";
    $button->setRedirect($link);
    return $button;
  }

  function addOkButton($label = "OK")
  {
    $button = $this->addSubmitButton($label);
    $button->value = "ok";
    return $button;
  }

  function addCancelButton($label = "Cancel")
  {
    $button = $this->addSubmitButton($label);
    $button->value = "cancel";
    return $button;
  }
*/

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
