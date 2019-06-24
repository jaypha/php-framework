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
    fwrite(STDERR, "$prompt: ");
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
    if ($default) $prompt .= " [$default]";
    $prompt .= ": ";
    fwrite(STDERR, $prompt);
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
