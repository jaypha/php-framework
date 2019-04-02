<?php
//----------------------------------------------------------------------------
// Functions for use with random generation
//----------------------------------------------------------------------------

namespace Jaypha;

function randomString($n = 8)
{
  $s = "";
  for ($i=0; $i<$n; ++$i)
      $s .= chr(rand(97,122));

  return $s;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
