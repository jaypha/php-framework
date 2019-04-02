<?php
//----------------------------------------------------------------------------
// Simple HtmlTable
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Table extends Element
{
  public $head = [];
  public $body = [];
  public $foot = [];

  public $cols = [];

  function __construct() { parent::__construct("table"); $this->__vars["body"] = ""; }
  function __display()
  {
    assert(is_array($this->head));
    assert(is_array($this->body));
    assert(is_array($this->foot));

    if (count($this->cols))
    {
      foreach ($this->cols as $col)
        $col->display();
    }

    if (count($this->head))
    {
      echo "<thead>";
      foreach ($this->head as $row)
        $this->printRow($row, "th");
      echo "</thead>";
    }

    echo "<tbody>";
    foreach ($this->body as $row)
      $this->printRow($row, "td");
    echo "</tbody>";

    if (count($this->foot))
    {
      echo "<tfoot>";
      foreach ($this->foot as $row)
        $this->printRow($row, "td");
      echo "</tfoot>";
    }
  }

  protected function printRow($cells, $tagName = "td")
  {
    assert ($tagName == "td" || $tagName == "th");
    echo "<tr>";
    foreach ($cells as $cell)
      echo "<$tagName>$cell</$tagName>";
    echo "</tr>";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
