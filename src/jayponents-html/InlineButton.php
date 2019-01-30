<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class InlineButton extends Button
{
  function __construct($label = null)
  {
    parent::__construct($label);
    $this->cssClasses[] = "inline-button";
  }

  function displayInner()
  {
    echo "<span>";
    parent::displayInner();
    echo "</span>";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
