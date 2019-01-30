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
      case "value":
      case "type":
        if (array_key_exists($p, $this->attributes))
          return $this->attributes[$p];
        else
          return null;
      case "required":
      case "autofocus":
        return isset($this->attributes[$p]);
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "value":
      case "type":
        $this->attributes[$p] = $v;
        break;
      case "required":
      case "autofocus":
        if ($v)
          $this->attributes[$p] = true;
        else
          unset($this->attributes[$p]);
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
