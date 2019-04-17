<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
  function testValid()
  {
    $v = new Validate([ "a"=>"1345", "b"=>"23", "c"=>"98", "d"=>"111233" ]);
    $v->extractId("a");
    $v->extractId("b");
    $v->extractId("c");
    $this->assertTrue($v->success);
    $v->extractId("e");
    $this->assertFalse($v->success);
    $v->extractId("d");
    $this->assertFalse($v->success);
  }

  function testValidateId()
  {
    $v = new Validate([ "a"=>"1345", "b"=>"23", "c"=>"98", "d"=>"111233" ]);

    $v->extractId("a");
    $v->extractId("b");
    $v->extractId("c");
    $v->extractId("d");

    $this->assertTrue($v->success);

    $v = new Validate([ "a"=>"-123", "b"=>"", "c"=>"dfg", "d"=>"23t" ]);

    $v->extractId("a");
    $v->extractId("b");
    $v->extractId("c");
    $v->extractId("d");
    $v->extractId("e");

    $this->assertFalse($v->success);

    $this->assertEquals($v->failures["a"], Validate::REASON_MISMATCH);
    $this->assertEquals($v->failures["b"], Validate::REASON_MISSING);
    $this->assertEquals($v->failures["c"], Validate::REASON_MISMATCH);
    $this->assertEquals($v->failures["d"], Validate::REASON_MISMATCH);
    $this->assertEquals($v->failures["e"], Validate::REASON_MISSING);
  }

  function testValidateString()
  {
    $v = new Validate([ "a"=>"abc", "b"=>"peaches", "c"=>"", "d"=>"111233" ]);

    $v->extractString("a");
    $v->extractString("b",2,4);
    $this->assertTrue($v->success);
    $v->extractString("c");
    $v->extractString("d");
    $v->extractString("e",false);

    $this->assertFalse($v->success);


    $s = "abc";
    $x = validateString($s);
    $this->assertTrue($x);
    $this->assertFalse(isFailure($x));

    $this->assertTrue(validateString($s, 2,4));
    $this->assertTrue(validateString($s, 2,4, "/[a-z]*/"));

    $x = validateString($s, 4,5);
    $this->assertInstanceOf(Failure::class, $x);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_TOO_SHORT);

    $x = validateString($s, 1,2);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_TOO_LONG);

    $x = validateString($s, 1,3, "/[1-9]+/");
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_MISMATCH);

    $a = [ "x" => "abc", "y" => "123" ];
    $x = extractString($a, "x", true, 2,4);
    $this->assertEquals($x, "abc");
    $this->assertFalse(isFailure($x));

    $x = extractString($a, "z", false, 2,4);
    $this->assertEquals($x, "");
    $this->assertFalse(isFailure($x));

    $x = extractString($a, "z", true, 2,4);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_MISSING);

    $x = extractString($a, "x", true, 2,4, "/[1-9]+/");
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_MISMATCH);
  }

  function testValidateEnumerated()
  {
    $options = [ "abc", "123", "-+=" ];

    $x = validateEnumerated("abc", $options);
    $this->assertTrue($x);
    $this->assertFalse(isFailure($x));

    $x = validateEnumerated(["abc", "123"], $options, 1,3);
    $this->assertTrue($x);
    $this->assertFalse(isFailure($x));

    $x = validateEnumerated([], $options, 1,3);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_TOO_SHORT);

    $x = validateEnumerated([ "abc", "123" ], $options, 0,1);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_TOO_LONG);

    $x = validateEnumerated("ret", $options);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_MISMATCH);

    $input = [ "w" => "abc", "z" => [ "abc", "xyz" ] ];

    $x = extractEnumerated($input, "w", $options);
    $this->assertEquals($x, "abc");
    $this->assertFalse(isFailure($x));

    $x = extractEnumerated($input, "z", $options, 0, 4);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_MISMATCH);

    $x = extractEnumerated($input, "x", $options);
    $this->assertNull($x);
    $this->assertFalse(isFailure($x));

    $x = extractEnumerated($input, "x", $options, 0, 3);
    $this->assertEquals($x, []);
    $this->assertFalse(isFailure($x));

    $x = extractEnumerated($input, "x", $options, 1, 3);
    $this->assertTrue(isFailure($x));
    $this->assertEquals($x->reason, REASON_MISSING);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
