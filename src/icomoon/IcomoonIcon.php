<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Icomoon;

use Jaypha\Jayponents\Html\Element;

class IcomoonIcon extends Element
{
  const SYMBOL_FILE = "/assets/symbol-defs.svg";

  public $iconName;

  function __construct($iconName, $iconClass)
  {
    parent::__construct("svg");
    $this->cssClasses[] = "icon";
    $this->cssClasses[] = $iconClass;
    $this->iconName = $iconName;
  }

  function displayInner()
  {
    echo "<use xlink:href='".self::SYMBOL_FILE."#$this->iconName'></use>";
  }

  static function icon($name)
  {
    switch ($name)
    {
      case "pending":
        return new IcomoonIcon("icon-circle", "icon-pending");
      default:
        return new IcomoonIcon("icon-$name", "icon-$name");
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
