
{foreach $controls as $control}
 {if $control instanceof \Jaypha\Jayponents\Html\Control}
   <div class='control-group-row'>
    <span class='required'>{$control->required?"*":""}</span>
    <span class='label'>{$control->label}</span>
    <span class='control-holder'>
     {jayp $control}
    </span>
   </div>
 {else}
   {jayp $control}
 {/if}
{/foreach}

{*----------------------------------------------------------------------------
 * Copyright (C) 2019 Jaypha.
 * License: BSL-1.0
 * Author: Jason den Dulk
 *}
