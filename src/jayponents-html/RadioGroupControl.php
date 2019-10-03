<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class RadioGroupControl extends Control
{
  private $options = [];
  public $value = null;
  public $autofocus;

  function __construct($name)
  {
    $this->validator = new \Jaypha\ExtractEnum($name);
    parent::__construct($name);
    $this->tagName = "span";
  }

  function displayInner()
  {
    // TODO replace with a template
    foreach ($this->options as $option => $label)
    {
      $checked = ($this->value === $option) ? "checked" : "";
      echo "<label><input type='radio' name='$this->name' value='$option' $checked> $label</label>";
    }
  }

  function __get($p)
  {
    switch ($p) {
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      default:
        parent::__set($p, $v);
    }
  }

  //-------------------------------------------------------
  // Validation methods

  function setOptions(iterable $options, $failMessageFormat = null)
  {
    $this->options = $options;
    if (!$failMessageFormat)
      $failMessageFormat = self::FAIL_INVALID_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setOptions(array_keys($options),  $failMessageFormat);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
