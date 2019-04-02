<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class JayphaEnum extends Element
{
  function __set($p, $v)
  {
    switch ($p)
    {
      case "options":
        $this->attributes[$p] = json_encode($v);
        break;
      case "value":
        $this->attributes[$p] = $v;
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
