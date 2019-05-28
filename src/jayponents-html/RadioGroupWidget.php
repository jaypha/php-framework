<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class RadioGroupWidget extends Widget
{
  public $options = [];
  public $useValues = true;
  protected $widgets;
  public $value;

  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "span";
  }

  function display()
  {
    foreach ($this->options as $value => $label)
    {
      $widget = new InputWidget($this->name);
      $widget->form = $this->form;
      $widget->type = "radio";
      $widget->value = $value;
      if ($this->value == $value)
        $widget->attributes["selected"] = true;
      $this->widgets[$value] = $widget;
    }
    $this->set("widgets", $this->widgets);
    parent::display();
  }

  function displayInner()
  {
    if ($this->_template)
      parent::displayInner();
    else
    {
      foreach ($this->widgets as $value => $widget)
        echo "<label>$widget {$this->options[$value]}</label>";
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
