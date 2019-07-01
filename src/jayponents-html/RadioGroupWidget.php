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
  public $value;

  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "span";
  }

  function displayInner()
  {
    $widgets = [];
    foreach ($this->options as $value => $label)
    {
      $widget = new InputWidget($this->name);
      $widget->form = $this->form;
      $widget->type = "radio";
      $widget->value = $value;
      if ($this->value === $value)
        $widget->attributes["checked"] = true;
      $widgets[$value] = $widget;
    }

    if ($this->_template)
    {
      $this->set("widgets", $widgets);
      parent::displayInner();
    }
    else
    {
      foreach ($widgets as $value => $widget)
        echo "<label>$widget {$this->options[$value]}</label>";
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
