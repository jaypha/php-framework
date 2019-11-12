<?php
//----------------------------------------------------------------------------
// Display helpers for common button types
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

function linkAsButton($label, $link)
{
  return "<a class='button' href='$link'>$label</a>";
}

function linkButton($label, $link)
{
  return "<button type='button' onclick='document.location=\"$link\"'>$label</button>";
}

function scriptButton($label, $script)
{
  return "<button type='button' onclick='$script'>$label</button>";
}

function submitButton($name, $value, $label = "Submit")
{
  return "<button type='submit' name='$name'>$label</button>";
}

function resetButton($label = "Reset")
{
  return "<button type='reset'>$label</button>";
}

function nopButton($label)
{
  return "<button type='button'>$label</button>";
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
