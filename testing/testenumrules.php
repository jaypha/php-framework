<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

require ".startup.php";

//require "validation/ExtractEnum.php";


$x = new IsOneOfRule("X", [ "a", "b", "c", "d" ]);

$s = [
  [ "X" => "b" ],
  [ "X" => [ "b", "c" ] ],

  [ "X" => "x" ],
  [ "X" => [ "a", "x" ] ],
  [ "X" => [] ],
];

foreach ($s as $a)
{
  $rx = $x->extract($a, $a);
}

$x = new MinCountRule("X", 3);
$y = new MaxCountRule("X", 5);

$s = [
 [ "X" => [] ],
 [ "X" => "b" ],
 [ "X" => [ "b", "c" ] ],
 [ "X" => [ "b", "c", "c" ] ],
 [ "X" => [ "b", "c", "c", "c" ] ],
 [ "X" => [ "b", "c", "c", "c", "c" ] ],
 [ "X" => [ "b", "c", "c", "c", "c", "c" ] ],
 [ "X" => [ "b", "c", "c", "c", "c", "c", "c" ] ],
 [ "X" => [ "b", "c", "c", "c", "c", "c", "c", "c" ] ]
];

foreach ($s as $a)
{
  $rx = $x->extract($a, $a);
  $ry = $y->extract($a, $a);

var_dump($ry);
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
