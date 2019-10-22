<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class ExtractBoolean extends ExtractValue
{
  function extract(iterable $source, iterable $resultsSoFar = []) : iterable
  {
    $resultsSoFar = parent::extract($source, $resultsSoFar);
    if ($resultsSoFar[$this->name] instanceof Fail)
      return $resultsSoFar;

    $resultsSoFar[$this->name] = (bool) $resultsSoFar[$this->name];
    return $resultsSoFar;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
