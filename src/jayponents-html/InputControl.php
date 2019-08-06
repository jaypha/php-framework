<?php
//----------------------------------------------------------------------------
// Component for <input> HTML elements
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

abstract class InputControl extends Control
{
  function __construct($name)
  {
    parent::__construct($name);
    $this->tagName = "input";
  }

  function __get($p)
  {
    switch ($p) {
      case "type":
        return $this->attributes[$p] ?? null;
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "type":
        $this->attributes[$p] = $v;
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
