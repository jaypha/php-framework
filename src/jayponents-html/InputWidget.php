<?php
//----------------------------------------------------------------------------
// Widget for text, password inputs
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class InputWidget extends Widget
{
  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "input";
  }

  function __get($p)
  {
    switch ($p) {
      case "pattern":
      case "value":
      case "type":
        return $this->attributes[$p] ?? null;
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "pattern":
      case "value":
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
