<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

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

function reduceBits(array $bitArray)
{
  return array_reduce($bitArray, function($c, $i) { return $c | (int) $i; }, 0);
}

function expandBits(int $bits)
{
  $x = 1;
  $bitArray = [];
  while ($x <= $bits)
  {
    if ($bits & $x)
      $bitArray[] = $bits;
    $x = $x << 1;
  }
  return $bitArray;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
