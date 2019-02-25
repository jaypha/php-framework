<?php
//----------------------------------------------------------------------------
// Display helpers for common button types
//----------------------------------------------------------------------------
// 
//----------------------------------------------------------------------------

namespace HPT;

function linkAsButton($label, $link)
{
  return "<a class='button' href='$link'>$label</a>";
}

function linkButton($label, $link)
{
  return "<button onclick='document.location=\"$link\"'>$label</button>";
}

function scriptButton($label, $script)
{
  return "<button type='button' onclick='$script'>$label</button>";
}

function submitButton($label = "Submit")
{
  return "<button type='submit'>$label</button>";
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
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
