<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
/*
  function testValid()
  {
    $v = new Validator([ "a"=>"1345", "b"=>"23", "c"=>"98", "d"=>"111233" ]);
    $v->extractId("a");
    $v->extractId("b");
    $v->extractId("c");
    $this->assertTrue($v->success);
    $v->extractId("e");
    $this->assertFalse($v->success);
    $v->extractId("d");
    $this->assertFalse($v->success);
  }
*/
  function testValidateId()
  {
    $source = [ "a"=>"1345", "b"=>"2s3" ];
    $source2 = [ "b"=>"2s3" ];

    $this->assertTrue(Validator::validateId("2365"));

    $v = Validator::validateId("2365a");
    $this->assertInstanceOf(\Exception::class, $v);
    $this->assertEquals(Validator::FAIL_INVALID, $v->getMessage());

    $v = Validator::extractId($source, "a");
    $this->assertEquals($source["a"],$v);

    $v = Validator::extractId($source, "b");
    $this->assertInstanceOf(\Exception::class, $v);
    $this->assertEquals(Validator::FAIL_INVALID, $v->getMessage());

    $v = Validator::extractId($source, "c");
    $this->assertInstanceOf(\Exception::class, $v);
    $this->assertEquals(Validator::FAIL_MISSING, $v->getMessage());

    $v = new Validator([ "a" => ["type"=>"id"]]);
    $r = $v->validate($source);
    $this->assertTrue(isset($r["success"]));
    $this->assertTrue(isset($r["values"]));
    $this->assertTrue(isset($r["failures"]));
    $this->assertTrue($r["success"]);
    $this->assertTrue(isset($r["values"]["a"]));
    $this->assertFalse(isset($r["failures"]["a"]));
    $this->assertEquals($source["a"],$r["values"]["a"]);


    $r = $v->validate($source2);

    $this->assertTrue(isset($r["success"]));
    $this->assertTrue(isset($r["values"]));
    $this->assertTrue(isset($r["failures"]));
    $this->assertFalse($r["success"]);
    $this->assertFalse(isset($r["values"]["a"]));
    $this->assertTrue(isset($r["failures"]["a"]));
    $this->assertEquals(Validator::FAIL_MISSING,$r["failures"]["a"]);
  }

  function testValidateString()
  {
    $source = [ "a"=>"abcdefg", "b"=>"tgh2s3" ];

    $this->assertTrue(Validator::validateString("abcdef"));
    $this->assertTrue(
      Validator::validateString(
        "abcdef",
        [
          "maxLength" => 10,
          "minLength" => 3,
          "regex" => "/[a-z]*/"
        ]
      )
    );

    $v = Validator::validateString(
      "a",
      [
        "maxLength" => 10,
        "minLength" => 3,
        "regex" => "/[a-z]*/"
      ]
    );
    $this->assertInstanceOf(\Exception::class, $v);
    $this->assertEquals(Validator::FAIL_TOO_SHORT, $v->getMessage());

    $v = Validator::validateString(
      "abcdefghijklmnopqrst",
      [
        "maxLength" => 10,
        "minLength" => 3,
        "regex" => "/[a-z]*/"
      ]
    );
    $this->assertInstanceOf(\Exception::class, $v);
    $this->assertEquals(Validator::FAIL_TOO_LONG, $v->getMessage());

    $v = Validator::validateString(
      "abc123",
      [
        "maxLength" => 10,
        "minLength" => 3,
        "regex" => "/^[a-z]*$/"
      ]
    );
    $this->assertInstanceOf(\Exception::class, $v);
    $this->assertEquals(Validator::FAIL_INVALID, $v->getMessage());
  }

  function testValidateBoolean()
  {
  }

  function testValidateInteger()
  {
  }

  function testValidateNumber()
  {
  }

  function testValidateDate()
  {
  }

  function testValidateEnumerated()
  {
  }

/*
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
*/
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
