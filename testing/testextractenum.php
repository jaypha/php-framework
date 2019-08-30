<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

require ".startup.php";


$x = new ExtractEnum("X");


$x->setOptions(["m","n","o","p"]);
$x->setRequired(false);
//$x->setMinCount(2, "too few dude!");
//$x->setMaxCount(3);


$s = [
 [ ],
 [ "X" => [] ],
 [ "X" => "b" ],
 [ "X" => "m" ],
 [ "X" => [ "m", "n" ] ],
 [ "X" => [ "m", "n", "o", "z" ] ],
 [ "X" => [ "m", "n", "o" ] ],
 [ "X" => [ "m", "n", "o", "p" ] ],
];

foreach ($s as $a)
{
  $r = $x->extract($a);
  var_dump($r);
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
