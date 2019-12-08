<?php
//----------------------------------------------------------------------------
// Component purely for holding groups of widgets.
//----------------------------------------------------------------------------
// Columns:
//  required - for required symbol
//  label    - field label
//  widget   - the widget
//  attn     - space for any additional attention
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class ControlGroup extends \Jaypha\Jayponents\Component
{
  public $form;
  protected $controls;

  function __construct($form = null)
  {
    $this->setTemplate("framework/jayponents-html/ControlGroup.tpl");
    $this->form = $form;
    $this->controls = new \ArrayObject();
    $this->set("controls", $this->controls);
  }

  //-------------------------------------------------------

  function addNonControl(\Jaypha\Jayponents\Component $c)
  {
    $this->controls[] = $c;
  }

  //-------------------------------------------------------

  function addStatic($text)
  {
    $c = new \Jaypha\Jayponents\Component();
    $c->add($text);
    $this->controls[] = $c;
  }

  //-------------------------------------------------------

  function addControl(Control $control)
  {
    $control->form = $this->form;
    $this->controls[$control->name] = $control;
    $this->set($control->name, $control);
    return $control;
  }

  //-------------------------------------------------------

  function addTextControl($name,$label = null)
  {
    $control = $this->addControl(new TextControl($name),$label);
    $control->label = $label;
    return $control;
  }

  //-------------------------------------------------------

  function addPasswordControl($name,$label = null)
  {
    $control = $this->addTextControl($name,$label);
    $control->type = "password";
    return $control;
  }

  //-------------------------------------------------------

  function addTextAreaControl($name,$label = null)
  {
    $control = $this->addControl(new TextAreaControl($name),$label);
    $control->label = $label;
    return $control;
  }

  //-------------------------------------------------------

  function addSelectControl($name,$label = null)
  {
    $control = $this->addControl(new SelectControl($name),$label);
    $control->label = $label;
    return $control;
  }

  //-------------------------------------------------------

  function addRadioGroupControl($name,$label = null)
  {
    $control = $this->addControl(new RadioGroupControl($name),$label);
    $control->label = $label;
    return $control;
  }

  //-------------------------------------------------------

  function addCheckboxControl($name,$label = null)
  {
    $control = $this->addControl(new CheckboxControl($name),$label);
    $control->label = $label;
    return $control;
  }

  //-------------------------------------------------------
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
