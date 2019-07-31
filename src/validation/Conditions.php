<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class IssetCondition implements Evaluation
{
  private $name;
  function __construct($name) { $this->name = $name; }
  function evaluate(iterable $resultsSoFar = []) : bool
  {
    return (array_key_exists($this->name, $resultsSoFar) &&
           $resultsSoFar[$this->name] != null);
  }
}

class EqualsCondition implements Evaluation
{
  private $name, $value;
  function __construct($name, $value) { $this->name = $name; $this->value = $value; }
  function evaluate(iterable $resultsSoFar = []) : bool
  {
    return (array_key_exists($this->name, $resultsSoFar) &&
           $resultsSoFar[$this->name] == $this->value);
  }
}

class ValueEvaluation implements Evaluation
{
  private $name;
  function __construct($name) { $this->name = $name; }
  function evaluate(iterable $resultsSoFar = [])
  {
    return $resultsSoFar[$this->name];
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
