<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class SortControl extends Control
{
  public $name;
  public $options = [];
  public $value = [];

  function __construct($name)
  {
    parent::__construct($name);
    $this->tagName = "ul";
    $this->cssClasses[] = "sort-control";
    $this->attributes["data-name"] = $name;
    $script = $this->addScript(new DocReadyScript());
    $script->add("var theList=dominus('ul[data-name=$this->name]');var theHidden=dominus('input[name=$this->name]');dragula(theList,{revertOnSpill:true}).on('drop',function(el){var theRanking=[];theList.children().forEach(function(e){theRanking.push(dominus(e).attr('data-id'));});theHidden.attr('value',theRanking.join(','));});");
  }

  //-------------------------------------------------------

  function display()
  {
    parent::display();
    echo "<input type='hidden' name='$this->name' value='".implode(",",$this->value)."'/>";
  }

  //-------------------------------------------------------

  function displayInner()
  {
    foreach ($this->value as $v)
      echo "<li data-id='$v'>{$this->options[$v]}</li>";
  }

  //-------------------------------------------------------

  function __get($p)
  {
    switch($p)
    {
      case "xxx":
        return xxx;
      default:
        return parent::__get($p);
    }
  }

  //-------------------------------------------------------

  function __set($p, $v)
  {
    switch($p)
    {
      case "xxx":
        xxx;
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

/* The javascript is as follows

  var theList = dominus('ul[data-name=$this->name]');
  var theHidden = dominus('input[name=$this->name]');
  dragula(theList, { revertOnSpill: true })
  .on('drop', function (el) {
      var theRanking = [];
      theList.children().forEach(function (e) {
        theRanking.push(dominus(e).attr('data-id'));
      });
      theHidden.attr('value',theRanking.join(','));
    }
  );
*/

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
