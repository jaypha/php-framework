<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

use PHPUnit\Framework\TestCase;

class ButtonTest extends TestCase
{
  function testButton()
  {
    $button = new Button("Press");
    $this->assertEquals("button", $button->type);
    $this->assertFalse($button->disabled);
    $this->assertNull($button->value);
    $this->assertNull($button->onclick);
    
    $this->assertEquals("<button type='button'>Press</button>", $button->__toString());

    $button->setRedirect("/home.php");
    $this->assertEquals("<button type='button' onclick='document.location=&quot;/home.php&quot;'>Press</button>", $button->__toString());

    $button->disabled = true;
    $button->type="something";
    $this->assertEquals("<button type='something' onclick='document.location=&quot;/home.php&quot;' disabled>Press</button>", $button->__toString());

    $button->value="v";
    $this->assertEquals("<button type='something' onclick='document.location=&quot;/home.php&quot;' disabled value='v'>Press</button>", $button->__toString());

    $this->assertTrue($button->disabled);
    $this->assertEquals("something", $button->type);
    $this->assertEquals("v", $button->value);
    $this->assertEquals("document.location=\"/home.php\"", $button->onclick);
  }

  function testSubmitButton()
  {
    $button = Button::submitButton("Press", "ok");
    $this->assertEquals("<button type='submit' value='ok'>Press</button>", $button->__toString());
  }

  function testLinkButton()
  {
    $button = Button::linkButton("Press", "/ok.php");
    $this->assertEquals("<button type='button' onclick='document.location=&quot;/ok.php&quot;'>Press</button>", $button->__toString());
  }

  function testOkButton()
  {
    $button = Button::okButton();
    $this->assertEquals("<button type='submit' value='ok'>OK</button>", $button->__toString());

    $button = Button::okButton("Yay!");
    $this->assertEquals("<button type='submit' value='ok'>Yay!</button>", $button->__toString());
  }

  function testCancelButton()
  {
    $button = Button::cancelButton();
    $this->assertEquals("<button type='submit' value='cancel'>Cancel</button>", $button->__toString());

    $button = Button::cancelButton("Boo!");
    $this->assertEquals("<button type='submit' value='cancel'>Boo!</button>", $button->__toString());
  }
}

//-
//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
