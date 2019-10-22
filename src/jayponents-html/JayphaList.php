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

  function column($column)
  {
    $this->columns[] = $column;
    return $column;
  }

  function addColumn($name, $label = null, $attributes = [])
  {
    return $this->column(new JayphaColumn("jaypha-column",$name, $label, $attributes));
  }

  function addTextColumn($name, $label = null, $attributes = [])
  {
    return $this->column(new JayphaColumn("jaypha-column",$name, $label, $attributes));
  }

  function addDateColumn($name, $label = null, $attributes = [])
  {
    return $this->column(new JayphaColumn("jaypha-datecolumn",$name, $label, $attributes));
  }

  function addEnumColumn($name, $label = null, $attributes = [])
  {
    return $this->column(new JayphaColumn("jaypha-enumcolumn",$name, $label, $attributes));
  }

  function setData($data)
  {
    $this->data = new Script();
    $this->data->type = "application/json";
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

  function __get($p)
  {
    switch ($p)
    {
      case "columnorder":
        return explode(" ", $this->attributes["columnorder"]);
        break;
      case "datacolumnasrowclass":
        return $this->attributes[$p];
        break;
      default:
        parent::__set($p,$v);
    }
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "columnorder":
        $this->attributes["columnorder"] = implode(" ", $v);
        break;
      case "datacolumnasrowclass":
        $this->attributes[$p] = $v;
        break;
      default:
        parent::__set($p,$v);
    }
  }
}

//----------------------------------------------------------------------------

class JayphaColumn extends Element
{
  public $label;

  function __construct($tagName, $name, $label = null, $attributes = [])
  {
    parent::__construct($tagName);
    $this->attributes["name"] = $name;
    $this->label = $label;
    if ($label)
      $this->add($label);
    foreach ($attributes as $i => $v)
    {
      if ($i == "options")
        $v = json_encode($v);
      $this->attributes[$i] = $v;
    }
  }

  function display()
  {
    if ($this->label)
    {
      if ($this->sortable)
      {
        $label = "<label>$this->label".
                 \Jaypha\Icomoon\IcomoonIcon::html("sort").
                 \Jaypha\Icomoon\IcomoonIcon::html("sort-asc").
                 \Jaypha\Icomoon\IcomoonIcon::html("sort-desc").
                 "</label>";
      }
      else
        $label = $this->label;
      $this->add($label);
    }
    parent::display();
  }

  function __get($p)
  {
    switch ($p)
    {
      case "sortable":
        return array_key_exists("sortable", $this->attributes);
        break;
      case "link":
        return $this->attributes[$p];
        break;
      default:
        parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p)
    {
      case "sortable":
        $this->attributes["sortable"] = (bool) $v;
        break;
      case "link":
        $this->attributes[$p] = $v;
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
