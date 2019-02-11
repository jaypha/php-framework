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
        return $this->attributes[$p] ?? null;
      default:
        parent::__get($p);
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
      case "value":
        $this->attributes[$p] = $v;
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
