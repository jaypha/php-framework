<?php
//----------------------------------------------------------------------------
// Functions useful with consoles
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

function hideTerm() { system('stty -echo'); }

//----------------------------------------------------------------------------

function restoreTerm() { system('stty echo'); }

//----------------------------------------------------------------------------

function collectPassword($prompt = null)
{
  if ($prompt)
    echo "$prompt: ";
  hideTerm();
  $password = rtrim(fgets(STDIN), PHP_EOL);
  restoreTerm();
  echo PHP_EOL;
  return $password;
}

//----------------------------------------------------------------------------

function collectInput(string $prompt = null, string $default = "")
{
  if ($prompt)
  {
    echo "$prompt";
    if ($default)
      echo " [$default]";
    echo ": ";
  }
  $input = rtrim(fgets(STDIN), PHP_EOL);
  if ($input == "")
    $input = $default;
  return $input;
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
