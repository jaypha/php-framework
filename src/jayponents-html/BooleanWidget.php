<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
// TODO setting value for Bool widgets doesn't work.
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class BooleanWidget extends Widget
{
  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "input";
    $this->attributes["type"]="checkbox";
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "value":
        $this->attributes["selected"] = (bool)$v;
        $this->attributes[$p] = $v;
        break;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
