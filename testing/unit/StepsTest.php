<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;

 
class StepsTest extends TestCase
{
  public static $sequence;

  public static function setUpBeforeClass()
  {
  }

  function setUp()
  {
    $this->momento = new SessionStepMomento("test");
  }

  function testAdvance()
  {
    $sequence = [
      [ "title" => "One" ],
      [ "title" => "Two" ],
      [ "title" => "Three" ],
    ];

    $steps = new Steps($sequence);
    $this->assertEquals(null, $steps->currentStep());
    $this->assertEquals(null, $steps->furthestStep());
    $this->assertEquals(null, $steps->getContentForStep());

    $steps->start();
    $this->assertEquals(0, $steps->currentStep());
    $this->assertEquals(0, $steps->furthestStep());
    $this->assertEquals(["title" => "One"], $steps->getContentForStep());

    $steps->advanceStep();
    $this->assertEquals(1, $steps->currentStep());
    $this->assertEquals(1, $steps->furthestStep());
    $this->assertEquals(["title" => "Two"], $steps->getContentForStep());

    $steps->advanceStep();
    $this->assertEquals(2, $steps->currentStep());
    $this->assertEquals(2, $steps->furthestStep());
    $this->assertEquals(["title" => "Three"], $steps->getContentForStep());

    $steps->advanceStep();
    $this->assertEquals(null, $steps->currentStep());
    $steps->advanceStep();
    $this->assertEquals(null, $steps->currentStep());
  }

  function testReverse()
  {
    $sequence = [
      [ "title" => "One" ],
      [ "title" => "Two" ],
      [ "title" => "Three" ],
      [ "title" => "Four" ],
    ];

    $steps = new Steps($sequence);

    $steps->start();
    $steps->advanceStep();
    $steps->advanceStep();
    $this->assertEquals(2, $steps->currentStep());
    $this->assertEquals(2, $steps->furthestStep());

    $steps->reverseStep();
    $this->assertEquals(1, $steps->currentStep());
    $this->assertEquals(2, $steps->furthestStep());
    $this->assertEquals(["title" => "Two"], $steps->getContentForStep());

    $steps->reverseStep();
    $this->assertEquals(0, $steps->currentStep());

    $steps->reverseStep();
    $this->assertEquals(0, $steps->currentStep());

    $steps->advanceStep();
    $this->assertEquals(1, $steps->currentStep());
    $steps->advanceStep();
    $this->assertEquals(2, $steps->currentStep());
    $steps->advanceStep();
    $this->assertEquals(3, $steps->currentStep());
    $this->assertEquals(3, $steps->furthestStep());
    $this->assertEquals(["title" => "Four"], $steps->getContentForStep());
  }

  function testGoto()
  {
    $sequence = [
      [ "title" => "One" ],
      [ "title" => "Two" ],
      [ "title" => "Three" ],
      [ "title" => "Four" ],
    ];

    $steps = new Steps($sequence);

    $steps->start();
    $steps->advanceStep();
    $steps->advanceStep();
    $this->assertEquals(2, $steps->currentStep());
    $this->assertEquals(2, $steps->furthestStep());

    $x = $steps->gotoStep(0);
    $this->assertTrue($x);
    $this->assertEquals(0, $steps->currentStep());
    $this->assertEquals(2, $steps->furthestStep());

    $x = $steps->gotoStep(3);
    $this->assertFalse($x);
    $this->assertEquals(0, $steps->currentStep());
    $this->assertEquals(2, $steps->furthestStep());
  }

  function testStop()
  {
    $sequence = [
      [ "title" => "One" ],
      [ "title" => "Two" ],
      [ "title" => "Three" ],
      [ "title" => "Four" ],
    ];

    $steps = new Steps($sequence);

    $steps->start();
    $steps->advanceStep();
    $this->assertEquals(1, $steps->currentStep());

    $steps->stop();

    $this->assertNull($steps->currentStep());
    $this->assertNull($steps->furthestStep());
  }

  function testTest()
  {
    $sequence = [
      [ "title" => "One", "test" => function() { return true; } ],
      [ "title" => "Two", "test" => function() { return true; }  ],
      [ "title" => "Three", "test" => function() { return false; } ],
      [ "title" => "Four", "test" => function() { return true; } ],
    ];

    $steps = new Steps($sequence);

    $steps->start();

    $steps->advanceStep();
    $this->assertEquals(1, $steps->currentStep());
    $steps->advanceStep();
    $this->assertEquals(3, $steps->currentStep());
  }

  function testMomento()
  {
    $sequence = [
      [ "title" => "One" ],
      [ "title" => "Two" ],
      [ "title" => "Three" ],
    ];

    $momento = new SessionStepMomento("test");

    $steps = new Steps($sequence, $momento);
    $this->assertEquals(null, $steps->currentStep());
    $this->assertEquals(null, $steps->furthestStep());
    $this->assertEquals(null, $steps->getContentForStep());

    $steps->start();
    $this->assertEquals(0, $steps->currentStep());
    $this->assertEquals(0, $steps->furthestStep());
    $this->assertEquals(["title" => "One"], $steps->getContentForStep());

    $steps->advanceStep();
    $this->assertEquals(1, $steps->currentStep());
    $this->assertEquals(1, $steps->furthestStep());
    $this->assertEquals(["title" => "Two"], $steps->getContentForStep());


    $steps2 = new Steps($sequence, $momento);
    $this->assertEquals(1, $steps2->currentStep());
    $this->assertEquals(1, $steps2->furthestStep());
  }

  function tearDown()
  {
  }

  public static function tearDownAfterClass()
  {
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
