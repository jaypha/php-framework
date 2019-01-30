<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
// Columns:
//  required - for required symbol
//  label    - field label
//  widget   - the widget
//  attn     - space for any additional attention
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class FormFragment extends Element
{
  protected $form;
  protected $fields = [];
  protected $buttonRows = [];

  function __construct($form)
  {
    parent::__construct("fieldset");
    $this->form = $form;
    $this->fields = new \ArrayObject();
    $this->set("fields", $this->fields);
    $this->buttonRows = new \ArrayObject();
    $this->set("buttonRows", $this->buttonRows);
  }

  //-----------------------------------

  function displayInner()
  {
    if ($this->_template == null)
    {
      foreach ($this->fields as $field)
      {
        echo "<div class='p basic-form-row'>";
        echo "<span class='required'>",$field["widget"]->required?"*":"","</span>";
        echo "<span class='label'>{$field["label"]}</span>";
        $field["widget"]->display();
        echo "<span class='attn'></span>";
        echo "</div>";
      }
      foreach ($this->buttonRows as $row)
        $row->display();
    }
    else
      parent::displayInner();
  }

  //-----------------------------------

  function addWidget($widget, string $label)
  {
    $this->fields[$widget->name] = [ "widget" => $widget, "label" => $label ];
    $widget->form = $this->form;
    return $widget;
  }

  //-----------------------------------

  function addTextWidget($name, string $label)
  {
    return $this->addWidget(new InputWidget($name), $label);
  }

  //-----------------------------------

  function addPasswordWidget($name, string $label)
  {
    $widget = $this->addTextWidget($name, $label);
    $widget->type = "password";
    return $widget;
  }

  //-----------------------------------

  function addButtonRow($buttonRow = null)
  {
    if ($buttonRow == null) $buttonRow = new ButtonRow();
    $this->buttonRows[] = $buttonRow;
    return $buttonRow;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
