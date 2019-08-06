<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

foreach ($controls as $control)
{
  echo "<div class='p two-column-form-row'>";
  echo "<span class='required'>",$control->required?"*":"","</span>";
  echo "<span class='label'>$control->label</span>";
  echo "<span class='control-holder'>";
  $control->display();
  echo "</span>";
  echo "<span class='attn'></span>";
  echo "</div>";
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
