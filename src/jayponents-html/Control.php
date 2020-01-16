<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

use Jaypha\ValidateRule;
use Jaypha\ValidateRuleCollection;

abstract class Control extends Element implements ValidateRuleCollection
{
  const FAIL_MISSING_FORMAT = "Please provide a value for '%l'";
  const FAIL_INVALID_FORMAT = "The value for '%l' is invalid";
  const FAIL_MISMATCH_FORMAT = "The values for '%l' and '%o' must be the same";

  public $form;
  public $label;
  protected $validator; // type ExtractValue

  //-------------------------------------------------------

  function __construct($name)
  {
    parent::__construct();
    $this->name = $name;
    $this->cssClasses[] = "form-control";
  }

  //-------------------------------------------------------

  function display()
  {
    if (
      $this->value === null &&
      $this->form !== null &&
      array_key_exists($this->name, $this->form->values)
    )
      $this->value = $this->form->values[$this->name];

    parent::display();
  }

  //-------------------------------------------------------

  function __get($p)
  {
    switch ($p) {
      case "name":
      case "value":
        return $this->attributes[$p] ?? null;
      case "required":
      case "autofocus":
      case "disabled":
        return isset($this->attributes[$p]);
      case "validator":
        return $this->validator;
      default:
        return parent::__get($p);
    }
  }

  //-------------------------------------------------------

  function __set($p, $v)
  {
    switch ($p) {
      case "name":
      case "value":
        $this->attributes[$p] = $v;
        break;
      case "required":
        $this->setRequired($v);
        break;
      case "autofocus":
      case "disabled":
        if ($v)
          $this->attributes[$p] = true;
        else
          unset($this->attributes[$p]);
        break;
      default:
        parent::__set($p, $v);
    }
  }

  //-------------------------------------------------------

  function setRequired($required, $failMessageFormat = null)
  {
    if (!$failMessageFormat)
      $failMessageFormat = self::FAIL_MISSING_FORMAT;
    $failMessageFormat = str_replace("%l", $this->label, $failMessageFormat);
    $this->validator->setRequired($required, $failMessageFormat);

    if ($required)
      $this->attributes["required"] = true;
    else
      unset($this->attributes["required"]);

    return $this;
  }

  function setEqualTo(Control $other, $failMessageFormat = null)
  {
    $rule = new \Jaypha\EqualToRule($this->name, $other->name);
    $this->validator->addRule($rule);
    if (!$failMessageFormat)
      $failMessageFormat = self::FAIL_MISMATCH_FORMAT;
    $failMessageFormat = str_replace(["%l", "%o"], [$this->label, $other->label], $failMessageFormat);
    $rule->setFailMessageFormat(\Jaypha\FAIL_MISMATCH, $failMessageFormat);
  }

  //-------------------------------------------------------

  function addRule(ValidateRule $rule) : ValidateRuleCollection
  {
    $this->validator->addRule($rule);
    return $this;
  }

  //-------------------------------------------------------

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    $format = str_replace("%l", $this->label, $format);
    $this->validator->setFailMessageFormat($code, $format);
    return $this;
  }

  //-------------------------------------------------------

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    return $this->validator->extract($source, $resultsSoFar);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
