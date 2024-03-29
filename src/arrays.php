<?php
//----------------------------------------------------------------------------
// Extra array functions
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

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

//----------------------------------------------------------------------------

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

function reduceBits(array $bitArray)
{
  return array_reduce($bitArray, function($c, $i) { return $c | (int) $i; }, 0);
}

//----------------------------------------------------------------------------

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

function arrayAsChunks(array &$array, $limit = 1000)
{
  $i = 0;
  $r = [];

  while ($i <= count($array))
  {
    $r[] = array_slice($array, $i, $limit);
    $i += $limit;
  }
  return $r;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
