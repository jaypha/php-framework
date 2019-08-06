<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class SelectControl extends Control
{
  const FAIL_TOO_MANY_FORMAT = "You can choose, at most, %n items for '%l'";
  const FAIL_TOO_FEW_FORMAT = "You must choose at least %n items for '%l'";
  const FAIL_INVALID_FORMAT = "The value for '%l' is invalid";

  const NULL_OPTION_LABEL = "-- Please select --";

  private $options = [];

  public $value; 

  function __construct($name, $form = null)
  {
    $this->validator = new \Jaypha\ExtractEnum($name);
    parent::__construct($name, $form);
    $this->tagName = "select";
  }

  function displayInner()
  {
    if ($this->value === null && !isset($this->options[""]))
      echo "<option value=''>".self::NULL_OPTION_LABEL."</option>";
    $this->displayOptionGroup($this->options);
  }

  protected function displayOptionGroup(&$group)
  {
    foreach ($group as $value => &$label)
    {
      if (is_array($label))
      {
        echo "<optgroup label='$value'>";
        $this->displayOptionGroup($label);
        echo "</optgroup>";
      }
      else
      {
        echo "<option";
        echo " value='$value'";
        if ($this->hasValue($value))
          echo " selected";
        echo ">$label</option>";
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
      case "autofocus":
        if ($v)
          $this->attributes[$p] = true;
        else
          unset($this->attributes[$p]);
        break;
      case "multiple":
        if ($v)
          $this->setMaxCount("all");
        else
          $this->setMaxCount(1);
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

  function setMinCount($minCount, $failMessageFormat = null)
  {
    if (!$failMessageFormat)
      $failMessageFormat = self::FAIL_TOO_SHORT_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setMinCount($minCount,  $failMessageFormat);
  }

  function setMaxCount($maxCount, $failMessageFormat = null)
  {
    if (!$failMessageFormat)
      $failMessageFormat = self::FAIL_TOO_LONG_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setMaxCount($maxCount,  $failMessageFormat);
    if ($maxCount == 1)
      unset($this->attributes["multiple"]);
    else
      $this->attributes["multiple"] = true;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
