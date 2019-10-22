<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class OneOfRequiredRule extends ValidateRuleBase
{
  protected $name, $nameList;

  function __construct(string $name, array $nameList)
  {
    $this->name = $name;
    $this->nameList = $nameList;
  }

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    $exists = false;
    foreach ($this->nameList as $name)
    {
      if (
        array_key_exists($name, $source) &&
        $source[$name] != "" &&
        $source[$name] !== []
      )
        $exists = true;
    }
    if (!$exists)
    {
      $message = $this->errorFormats[FAIL_MISSING] ?? null;
      $resultsSoFar[$this->name] = new Fail(FAIL_MISSING, $message);
    }
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
