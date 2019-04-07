<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
// PHP class to construct the 'jaypha-table' web component.
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class JayphaList extends Element
{
  protected $data = null;
  protected $columns = [];

  function __construct()
  {
    parent::__construct("jaypha-list");
  }

  function addColumn($name, $label = null, $attributes = [])
  {
    $column = new Element("jaypha-column");
    $column->attributes["name"] = $name;
    if ($label)
      $column->add($label);
    foreach ($attributes as $i => $v)
      $column->attributes[$i] = $v;
    $this->columns[] = $column;
    return $column;
  }

  function setData($data)
  {
    $this->data = new Element("script");
    $this->data->attributes["type"] = "application/json";
    $this->data->add(json_encode($data));
  }

  function displayInner()
  {
    echo "<jaypha-colgroup>";
    foreach ($this->columns as $column)
      $column->display();
    echo "</jaypha-colgroup>";
    if ($this->data)
      $this->data->display();
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "columnorder":
        $this->attributes["columnorder"] = implode(" ", $v);
        break;
      default:
        parent::__set($p,$v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
