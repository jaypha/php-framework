<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;
use Jaypha\Jayponents\Html\BoxLink;

class BoxLinkTest extends TestCase
{
  function testEmpty()
  {
    $link = new BoxLink();
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box'><span class='content'></span></a>", $s);
  }

  function testBasic()
  {
    $link = new BoxLink();
    $link->content->add("Some link somewhere");
    $link->href = "target.html";
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box' href='target.html'><span class='content'>Some link somewhere</span></a>", $s);
  }

  function testLeft()
  {
    $link = new BoxLink();
    $link->left = "<img>";
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box'><span class='left'><img></span><span class='content'></span></a>", $s);
  }

  function testRight()
  {
    $link = new BoxLink();
    $link->right = "<img>";
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box'><span class='content'></span><span class='right'><img></span></a>", $s);
  }

  function testBoth()
  {
    $link = new BoxLink();
    $link->left = "Left";
    $link->right = "Right";
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box'><span class='left'>Left</span><span class='content'></span><span class='right'>Right</span></a>", $s);
  }

  function testMake()
  {
    $link = BoxLink::makeBoxLink(
      "link",
      "Some Content",
      "Left Stuff",
      "Right Stuff"
    );
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box' href='link'><span class='left'>Left Stuff</span><span class='content'>Some Content</span><span class='right'>Right Stuff</span></a>", $s);

    $link = BoxLink::makeBoxLink(
      "link",
      "Some Content",
      "Left Stuff"
    );
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box' href='link'><span class='left'>Left Stuff</span><span class='content'>Some Content</span></a>", $s);

    $link = BoxLink::makeBoxLink(
      "link",
      "Some Content"
    );
    $s = $link->__toString();
    $this->assertEquals("<a class='box-link box' href='link'><span class='content'>Some Content</span></a>", $s);
  }

}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
