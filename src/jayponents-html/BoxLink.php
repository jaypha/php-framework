<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class BoxLink extends Element
{
  public $left = null;
  public $content;
  public $right = null;

  static function makeBoxLink($href, $content, $left = null, $right = null)
  {
    $boxLink = new BoxLink();
    $boxLink->href = $href;
    $boxLink->content->add($content);
    $boxLink->left = $left;
    $boxLink->right = $right;
    return $boxLink;
  }

  function __construct()
  {
    $this->tagName = "a";
    $this->cssClasses[] = "box-link box";
    $this->content = new Element();
    $this->content->tagName = "span";
    $this->content->cssClasses[] = "content";
  }

  //-------------------------------------------------------

  function display()
  {
    $this->addChild("left");
    $this->add($this->content);
    $this->addChild("right");

    parent::display();
  }

  protected function addChild($type)
  {
    if ($this->$type)
    {
      $comp = new Element();
      $comp->tagName = "span";
      $comp->cssClasses[] = $type;
      $comp->add($this->$type);
      $this->add($comp);
    }
  }

  //-------------------------------------------------------

  function __get($p)
  {
    switch($p)
    {
      case "href":
        return $this->attributes["href"];
      default:
        return parent::__get($p);
    }
  }

  //-------------------------------------------------------

  function __set($p, $v)
  {
    switch($p)
    {
      case "href":
        $this->attributes["href"] = $v;
        break;
      default:
        parent::__set($p, $v);
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
