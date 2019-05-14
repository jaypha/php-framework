<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
  protected $date;
  protected $dateImmutable;
    
  function setUp()
  {
  }

  // Test parseHttpRangeHeader

  function testNoEquals()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("somethingnotvalid");
  }

  function testNoRanges()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=");
  }

  function testBadRanges1()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=14-15,33");
    $ret = parseHttpRangeHeader("bytes=-");
  }

  function testBadRanges2()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=14-15-33");
  }

  function testRangesWithoutNumbers()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=-");
  }

  function testFirstNotNumber()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=rt-23");
  }

  function testSecondNotNumber()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=23-yh");
  }

  function testOutofOrserRanges()
  {
    $this->expectException(\Exception::class);
    $ret = parseHttpRangeHeader("bytes=33-46,16-14");
  }

  function testUnits()
  {
    $ret = parseHttpRangeHeader("bytes=23-56");
    $this->assertInternalType("array",$ret);
    $this->AssertArrayHasKey("unit",$ret);
    $this->assertEquals("bytes", $ret["unit"]);

    $ret = parseHttpRangeHeader("meters=someStuff");
    $this->assertInternalType("array",$ret);
    $this->AssertArrayHasKey("unit",$ret);
    $this->assertEquals("meters", $ret["unit"]);
  }

  function testParserNormal()
  {
    $str = "bytes=45-56";
    $ret = parseHttpRangeHeader($str);
    $this->AssertArrayHasKey("rangeSet",$ret);

    $this->assertInternalType("array",$ret["rangeSet"]);
    $this->assertCount(1,$ret["rangeSet"]);
    $this->checkNumbers($ret["rangeSet"][0], 45,56);
  }

  function testParserMultiple()
  {
    $str = "bytes=45-56,67-1001,9000-45000,45-,-56";
    $ret = parseHttpRangeHeader($str);
    $this->AssertArrayHasKey("rangeSet",$ret);

    $this->assertInternalType("array",$ret["rangeSet"]);
    $this->assertCount(5,$ret["rangeSet"]);
    $this->checkNumbers($ret["rangeSet"][0], 45,56);
    $this->checkNumbers($ret["rangeSet"][1], 67,1001);
    $this->checkNumbers($ret["rangeSet"][2], 9000,45000);
    $this->checkNumbers($ret["rangeSet"][3], 45,"");
    $this->checkNumbers($ret["rangeSet"][4], "",56);
  }

  function testNonByte()
  {
    $str = "stuff=somestuff";
    $ret = parseHttpRangeHeader($str);
    $this->assertEquals("stuff", $ret["unit"]);
    $this->AssertArrayHasKey("rangeSet",$ret);

    $this->assertEquals("somestuff",$ret["rangeSet"]);
  }

  function checkNumbers($a, $v1, $v2)
  {
    $this->assertInternalType("array",$a);
    $this->assertCount(2,$a);
    $this->AssertArrayHasKey(0,$a);
    $this->AssertArrayHasKey(1,$a);
    $this->assertEquals($v1, $a[0]);
    $this->assertEquals($v2, $a[1]);
  }

  // Test interperetByteRanges

  function testZeroSizeRange()
  {
    $this->expectException(\Exception::class);
    $s = "bytes=-0";
    $r = parseHttpRangeHeader($s);
    $ret = interperetByteRanges($r["rangeSet"], 100);
  }

  function testExceedSize()
  {
    $this->expectException(\Exception::class);
    $s = "bytes=102-107";
    $r = parseHttpRangeHeader($s);
    $ret = interperetByteRanges($r["rangeSet"], 100);
  }

  function testNormalInterperet()
  {
    $s = "bytes=-56,-123,14-,23-67,87-1000,38-38,14-99";
    $r = parseHttpRangeHeader($s);
    $ret = interperetByteRanges($r["rangeSet"], 100);

    $this->assertInternalType("array",$ret);
    $this->assertCount(7,$ret);

    $this->checkNumbers($ret[0], 100-56, 56);
    $this->checkNumbers($ret[1], 0,100);
    $this->checkNumbers($ret[2], 14,100-14);
    $this->checkNumbers($ret[3], 23,67-23+1); // Remember, its inclusive at both ends
    $this->checkNumbers($ret[4], 87,13);
    $this->checkNumbers($ret[5], 38,1);
    $this->checkNumbers($ret[6], 14,100-14);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
