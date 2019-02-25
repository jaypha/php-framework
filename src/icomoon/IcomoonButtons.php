<?php
//----------------------------------------------------------------------------
// A button row consisting of Icomoon icon buttons
//----------------------------------------------------------------------------

namespace Jaypha\Icomoon;

use Jaypha\Jayponents\Html\ButtonRow;
use Jaypha\Jayponents\Html\Button;

class IcomoonButtons extends ButtonRow
{
  public $buttons;

  function __construct()
  {
    parent::__construct();
    $this->cssClasses[] = "icomoon-buttons";
  }

  function addIcon($iconName, $value = null)
  {
    $value = $value ?? $iconName;
    $this->addButton(Button::submitButton(IcomoonIcon::icon($iconName), $value));
  }

  function addIcons($buttonDefs)
  {
    foreach ($buttonDefs as $row)
    {
      if (is_array($row))
        $this->addIcon($row[0], $row[1]);
      else
        $this->addIcon($row);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
