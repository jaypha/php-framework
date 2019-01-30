<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

function hideTerm() { system('stty -echo'); }

function restoreTerm() { system('stty echo'); }

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
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
