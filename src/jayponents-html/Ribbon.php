<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class Ribbon extends Element
{
  function __constructor()
  {
    parent::__constructor();
    $this->cssClasses[] = "ribbon";
  }
}

class RibbonGroup extends Element
{
  public $caption;

  function __constructor()
  {
    parent::__constructor();
    $this->cssClasses[] = "ribbon-group";
  }
  
  function displayInner()
  {
    echo "<div>";
    parent::displayInner();
    echo "</div>";
    if ($this->caption)
      echo "<span>$this->caption</span>";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
