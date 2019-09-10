
{foreach $controls as $control}
 <div class='p control-group-row'>
  <span class='required'>{$control->required?"*":""}</span>
  <span class='label'>{$control->label}</span>
  <span class='control-holder'>
   {jayp $control}
  </span>
 </div>
{/foreach}

{*----------------------------------------------------------------------------
 * Copyright (C) 2019 Jaypha.
 * License: BSL-1.0
 * Author: Jason den Dulk
 *}
