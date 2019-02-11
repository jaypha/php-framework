<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Dialog extends Element
{
  public $jsEventListeners = [];

  function __construct($id)
  {
    assert($id != null);
    parent::__construct("dialog");
    $this->id = $id;
  }

  function display()
  {
    parent::display();
    echo "<script>(function (dlg) {
      dialogPolyfill.registerDialog(dlg);";
    foreach ($this->jsEventListeners as $event => $fn)
      echo "dlg.addEventListener('$event',$fn);";
    echo "})(document.getElementById('$this->id'));</script>";
  }

  function __get($p)
  {
    switch ($p)
    {
      case "jsVarName":
        return str_replace("-", "", lcfirst(ucwords($this->id, "-")));
      case "getElementJS":
        return "document.getElementById('$this->id')";
      case "showModal":
        return "$this->getElementJS.showModal()";
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "open":
        $this->attributes[$p] = $v;
        break;
      case "onclose":
        $this->jsEventListeners["close"] = $v;
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
