<?php
//----------------------------------------------------------------------------
// Forms within a dialog are very common
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

use Jaypha\Icomoon\IcomoonIcon;

class FormDialog extends Dialog
{
  public $form;

  function __construct()
  {
    parent::__construct();
    $this->form = new Form();
    $this->form->method = "dialog";
    $this->add($this->form);
  }

  function addFieldset()
  {
    return $this->form->addFieldset();
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
