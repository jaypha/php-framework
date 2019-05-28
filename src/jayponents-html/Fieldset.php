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

class Fieldset extends Element
{
  public $form;
  protected $fields = [];
  protected $buttonRows = [];

  function __construct($form = null)
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
        echo "<div class='p two-column-form-row'>";
        echo "<span class='required'>",$field["widget"]->required?"*":"","</span>";
        echo "<span class='label'>{$field["label"]}</span>";
        echo "<span class='widget-holder'>";
        $field["widget"]->display();
        echo "</span>";
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

  function addWidget($widget, string $label = null)
  {
    $this->fields[$widget->name] = [ "widget" => $widget, "label" => $label ];
    $widget->form = $this->form;
    return $widget;
  }

  //-----------------------------------

  function addTextWidget($name, string $label = null)
  {
    return $this->addWidget(new InputWidget($name), $label);
  }

  //-----------------------------------

  function addSelectWidget($name, string $label = null)
  {
    return $this->addWidget(new SelectWidget($name), $label);
  }

  //-----------------------------------

  function addDateWidget($name, string $label = null)
  {
    $widget = $this->addWidget(new InputWidget($name), $label);
    $widget->type = "date";
    return $widget;
  }

  //-----------------------------------

  function addCheckWidget($name, string $label = null)
  {
    $widget = $this->addWidget(new InputWidget($name), $label);
    $widget->type = "checkbox";
    return $widget;
  }

  //-----------------------------------

  function addBooleanWidget($name, string $label = null)
  {
    return $this->addWidget(new BooleanWidget($name), $label);
  }

  //-----------------------------------

  function addPasswordWidget($name, string $label = null)
  {
    $widget = $this->addTextWidget($name, $label);
    $widget->type = "password";
    return $widget;
  }

  //-----------------------------------

  function addTextAreaWidget($name, string $label = null)
  {
    return $this->addWidget(new TextAreaWidget($name), $label);
  }

  //-----------------------------------

  function addRadioGroupWidget($name, $label = null)
  {
    return $this->addWidget(new RadioGroupWidget($name), $label);
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
