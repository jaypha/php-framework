<?php
//----------------------------------------------------------------------------
// Widget for text, password inputs
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class SelectWidget extends Widget
{
  public $options = [];
  public $useValues = true;

  function __construct($name, $form = null)
  {
    parent::__construct($name, $form);
    $this->tagName = "select";
  }

  function displayInner()
  {
    $this->displayOptionGroup($this->options);
  }

  protected function displayOptionGroup(&$group)
  {
    foreach ($group as $value => &$label)
    {
      if (is_array($label))
      {
        echo "<optgroup label='$value'>\n";
        $this->displayOptionGroup($label);
        echo "</optgroup>\n";
      }
      else
      {
        echo "<option";
        if ($this->useValues)
        {
          echo " value='$value'";
          if ($this->hasValue($value))
            echo " selected";
        }
        else if ($this->hasValue($label))
          echo " selected";
                  
        echo ">$label</option>\n";
      }
    }
  }

  protected function hasValue($v)
  {
    if ($this->value === null)
      return false;
    if ($this->multiple)
      return in_array($v, $this->value);
    else
      return $this->value == $v;
  }

  function __get($p)
  {
    switch ($p) {
      case "value":
        if (array_key_exists($p, $this->attributes))
          return $this->attributes[$p];
        else
          return null;
      case "required":
      case "autofocus":
      case "multiple":
        return isset($this->attributes[$p]);
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "value":
        $this->attributes[$p] = $v;
        break;
      case "required":
      case "autofocus":
      case "multiple":
        if ($v)
          $this->attributes[$p] = true;
        else
          unset($this->attributes[$p]);
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
