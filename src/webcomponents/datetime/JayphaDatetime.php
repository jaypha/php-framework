<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class JayphaDatetime extends InputWidget
{
  function __construct($name)
  {
    parent::__construct($name);
    $this->tagName = "jaypha-datetime";
  }

  function __get($p)
  {
    switch ($p) {
      case "value":
        return \Jaypha\toDateTime($this->attributes[$p] ?? null);
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "value":
        $this->attributes[$p] = \Jaypha\toDateTime($v)->format(\DateTime::ISO8601);
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
