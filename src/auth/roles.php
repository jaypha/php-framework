<?php
//----------------------------------------------------------------------------
// User roles for authorisation
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;


function reduceRoles(array $roles)
{
  return array_reduce($roles, function($c, $i) { return $c | (int) $i; }, 0);
}

function expandRoles(int $roles)
{
  $x = 1;
  $r = [];
  while ($x <= $roles)
  {
    if ($roles & $x)
      $r[] = $role;
    $x = $x << 1;
  }
  return $r;
}

//----------------------------------------------------------------------------
// Does 'r1' include any of 'r2'.

function includesRole(int $r1, int $r2)
{
  return ($r1 & $r2) != 0;
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
