<?php
//----------------------------------------------------------------------------
// Form Element
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

use Jaypha\ValidateRule;
use Jaypha\ValidateRuleCollection;


class Form extends Element implements ValidateRuleCollection
{
  public $hiddens = [];
  public $values = [];

  protected $validator;

  function __construct(string $action = null)
  {
    parent::__construct("form");
    $this->validator = new \Jaypha\ValidateRuleList();

    if ($action != null)
      $this->attributes["action"] = $action;
    $this->attributes["method"] = "post";
    $this->attributes["novalidate"] = true;
  }

  //-----------------------------------

  protected function displayInner()
  {
    parent::displayInner();
    foreach ($this->hiddens as $n => $v)
      echo "<input type='hidden' name='$n' value='$v'>";
  }

  function __get($p)
  {
    switch ($p) {
      case "enctype":
      case "method":
      case "action":
      case "onsubmit";
        if (array_key_exists($p, $this->attributes))
          return $this->attributes[$p];
        else
          return null;
      default:
        return parent::__get($p);
    }
  }

  function __set($p, $v)
  {
    switch ($p) {
      case "enctype":
      case "method":
      case "action":
      case "onsubmit";
        $this->attributes[$p] = $v;
        break;
      default:
        parent::__set($p, $v);
    }
  }

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    if (!$resultsSoFar)
      $resultsSoFar = new \ArrayObject();
    return $this->validator->extract($source, $resultsSoFar);
  }

  function setFailMessageFormat(string $code, string $format):  ValidateRule
  {
    $this->validator->setFailMessageFormat($code,$format);
    return $this;
  }

  function addRule(ValidateRule $rule) : ValidateRuleCollection
  {
    $this->validator->addRule($rule);
    return $this;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2017-9 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
