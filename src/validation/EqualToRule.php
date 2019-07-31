<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

const FAIL_MISMATCH = "mismatch";

class EqualToRule extends ValidateRuleBase
{
  private $name, $other;
  function __construct(string $name, string $other) { $this->name = $name; $this->other = $other; }

  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    assert(array_key_exists($this->name, $resultsSoFar));

    if (!array_key_exists($this->other, $source) ||
      $source[$this->other] != $resultsSoFar[$this->name]
    )
    {
      $message = $this->errorFormats[FAIL_MISMATCH] ?? null;
      $resultsSoFar[$this->name] = new Fail(FAIL_MISMATCH, $message);
    }

    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
