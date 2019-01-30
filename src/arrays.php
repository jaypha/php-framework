<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

function arrayExtract(array &$array, array $keys, bool $cut = false)
{
  $r = [];
  foreach ($array as $k => $v)
    if (in_array($k, $keys))
    {
      $r[$k] = $v;
      if ($cut) unset($array[$k]);
    }
  return $r;
}

function matrixInvert($a)
{
  $b = array();
  foreach ($a as $row)
  {
    $i = 0;
    foreach ($row as $cell)
    {
      $b[$i][] = $cell;
      ++$i;
    }
  }
  return $b;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
