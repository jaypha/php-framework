<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Jaypha\Jayponents\Html;

function getTheForm()
{
  $form = new Html\Form("the-form");
  $group = new Html\ControlGroup($form);
  $group->setTemplate("jayponents-html/ControlGroup.php.tpl");

  $username = $group->addTextControl("username");
  $username->label = "Username";
  $username->required = true;
  $form->addRule($username);

  $password = $group->addTextControl("password");
  $password->type = "password";
  $password->label = "Password";
  $password->required = false;
  //$password->setRequired(true, "Give a password Dude!");
  $form->addRule($password);

  $form->add($group);
  return $form;
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
