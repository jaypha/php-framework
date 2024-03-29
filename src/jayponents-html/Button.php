<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Button  extends Element
{
  public $enabled = true;

  function __construct($label = null)
  {
    parent::__construct("button");
    $this->attributes["type"] = "button";
    if ($label) $this->add($label);
  }

  function setRedirect($url)
  {
    $this->attributes["onclick"] = "document.location=\"$url\"";
  }

  function __get($p)
  {
    switch ($p) {
      case "disabled":
        return $this->attributes[$p] ?? false;
      case "onclick":
      case "type":
      case "name":
      case "value":
        return $this->attributes[$p] ?? null;
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "disabled":
        $this->attributes[$p] = ($v == true);
        break;
      case "onclick":
      case "type":
      case "name":
      case "value":
        $this->attributes[$p] = $v;
        break;
      default:
        parent::__set($p, $v);
    }
  }

  static function submitButton($label, $value = "submit")
  {
    $button = new Button($label);
    $button->type="submit";
    $button->value = $value;
    $button->name = "submit";
    return $button;
  }

  static function linkButton($label, $link)
  {
    $button = new Button($label);
    $button->setRedirect($link);
    return $button;
  }

  static function okButton($label = "OK")
  {
    return self::submitButton($label, "ok");
  }

  static function cancelButton($label = "Cancel")
  {
    $button = new Button($label);
    $button->value = "cancel";
    return $button;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
