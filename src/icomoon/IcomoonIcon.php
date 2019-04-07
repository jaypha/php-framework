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
  const SYMBOL_FILE = \Config\ASSET_DIR."/icomoon/symbol-defs.svg";

  public $name;

  function __construct($name, $class)
  {
    parent::__construct("svg");
    $this->cssClasses[] = "icon";
    $this->cssClasses[] = "icon-$class";
    $this->name = $name;
  }

  function displayInner()
  {
    echo "<use xlink:href='".self::SYMBOL_FILE."#icon-$this->name'></use>";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
