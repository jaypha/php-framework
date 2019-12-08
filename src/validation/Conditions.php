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

//----------------------------------------------------------------------------

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

//----------------------------------------------------------------------------

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

class RulePassFailCondition implements Evaluation
{
  const PASS=true;
  const FAIL=false;

  private $ruleName, $passOrFail;
  function __construct($ruleName, $passOrFail = self::PASS)
  {
    $this->ruleName = $ruleName;
    $this->passOrFail = $passOrFail;
  }

  function evaluate(iterable $resultsSoFar = [])
  {
    assert(array_key_exists($this->ruleName, $resultsSoFar));

    return ($resultsSoFar[$this->ruleName] instanceof Fail) xor
            $this->passOrFail;
  }
}

//----------------------------------------------------------------------------

class AndCondition implements Evaluation
{
  const PASS=true;
  const FAIL=false;

  private $rule1, $rule2;
  function __construct($rule1, $rule2)
  {
    $this->rule1 = $rule1;
    $this->rule2 = $rule2;
  }

  function evaluate(iterable $resultsSoFar = [])
  {
    return $this->rule1->evaluate($resultsSoFar) &&
           $this->rule2->evaluate($resultsSoFar);
  }
}

//----------------------------------------------------------------------------

class OrCondition implements Evaluation
{
  const PASS=true;
  const FAIL=false;

  private $rule1, $rule2;
  function __construct($rule1, $rule2)
  {
    $this->rule1 = $rule1;
    $this->rule2 = $rule2;
  }

  function evaluate(iterable $resultsSoFar = [])
  {
    return $rule1->evaluate($resultsSoFar) ||
           $rule2->evaluate($resultsSoFar);
  }
}

//----------------------------------------------------------------------------

class NotCondition implements Evaluation
{
  private $rule1;
  function __construct($rule1)
  {
    $this->rule1 = $rule1;
  }

  function evaluate(iterable $resultsSoFar = [])
  {
    return !$rule1->evaluate($resultsSoFar);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
