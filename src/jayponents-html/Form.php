<?php
//----------------------------------------------------------------------------
// Form Element
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Form extends Element
{
  public $hiddens = [];
  public $values = [];
  protected $fragments;

  function __construct(string $action = null)
  {
    parent::__construct("form");
    if ($action != null)
      $this->attributes["action"] = $action;
    $this->attributes["method"] = "post";
    $this->fragments = new \ArrayObject();
    $this->set("fragments", $this->fragments);
  }

  //-----------------------------------

  function addFragment($fragment = null)
  {
    if ($fragment == null) $fragment = new FormFragment($this);
    $this->fragments[] = $fragment;
    return $fragment;
  }

  //-----------------------------------


  //-----------------------------------

  protected function displayInner()
  {
    parent::displayInner();
    foreach ($this->hiddens as $n => $v)
      echo "<input type='hidden' name='$n' value='$v'>";
  }

  function __get($p)
  {
    switch ($p) {
      case "enctype":
      case "method":
      case "action":
      case "onsubmit";
        if (array_key_exists($p, $this->attributes))
          return $this->attributes[$p];
        else
          return null;
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "enctype":
      case "method":
      case "action":
      case "onsubmit";
        $this->attributes[$p] = $v;
        break;
      case "submitHandler":
        $this->attributes["onsubmit"] = "return $v(this)";
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
