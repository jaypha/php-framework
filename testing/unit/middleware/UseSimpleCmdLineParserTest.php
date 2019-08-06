<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;
use Jaypha\Middleware\UseSimpleCmdLineParser as Parser;

require "middleware/UseSimpleCmdLineParser.php";
require __DIR__."/../../TestService.php";

class UseSimpleCmdLineParserTest extends TestCase
{
  function testNoArgs()
  {
    $service = new TestService([]);
    $service->add(new Parser());
    $parsedInput = $service->run(function($input,$service) {
      return $input;
    });

    $this->assertCount(0,$parsedInput);
  }

  function testNumberedArgs()
  {
    $service = new TestService([ "x", "y" ]);
    $service->add(new Parser());
    $parsedInput = $service->run(function($input,$service) {
      return $input;
    });

    $this->assertCount(2, $parsedInput);
    $this->assertEquals("x", $parsedInput[0]);
    $this->assertEquals("y", $parsedInput[1]);
  }

  function testNamedArgs()
  {
    $service = new TestService([ "--x=john", "--y=bill", "-z" ]);
    $service->add(new Parser());
    $parsedInput = $service->run(function($input,$service) {
      return $input;
    });

    $this->assertCount(3, $parsedInput);
    $this->assertArrayHasKey("x", $parsedInput);
    $this->assertArrayHasKey("y", $parsedInput);
    $this->assertArrayHasKey("z", $parsedInput);
    $this->assertEquals("john", $parsedInput["x"]);
    $this->assertEquals("bill", $parsedInput["y"]);
    $this->assertTrue($parsedInput["z"]);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
