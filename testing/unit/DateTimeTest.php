<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
  protected $date;
  protected $dateImmutable;
    
  function setUp()
  {
    $this->date = date("2018-01-01");
    $this->dateImmutable = dateImmutable("2018-01-01");
    setTimezone("+0200");
  }

  function testFromNull()
  {
    $this->assertNull(date(null));
    $this->assertNull(dateImmutable(null));
    $this->assertNull(toDateTime(null));
    $this->assertNull(toDateTimeImmutable(null));
  }

  function testType()
  {
    $this->assertInstanceOf(\DateTime::class, $this->date);
    $this->assertInstanceOf(\DateTimeImmutable::class, $this->dateImmutable);
  }

  function testStrValid()
  {
    $this->assertTrue(dateStrValid("2018-02-02"));
    $this->assertTrue(dateStrValid("20180202"));
    $this->assertFalse(dateStrValid("20-12-0202"));
    $this->assertFalse(dateStrValid("xyz"));
    $this->assertFalse(dateStrValid(""));
  }

  function testToDateTime()
  {
    $date = toDateTime(1517522400); // 2018-02-02T00:00:00+0200
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertEquals("2018-02-02T00:00:00+0200", $date->format(\DateTime::ISO8601));
    
    $date = toDateTime("2018-02-02");
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertEquals("2018-02-02T00:00:00+0200", $date->format(\DateTime::ISO8601));

    $date = today();
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date === toDateTime($date));
  }

  function testToDateTimeString()
  {
    $mTime = toDateTimeString("2018-02-02 +6hours +21minutes");
    $this->assertEquals("2018-02-02T06:21:00+0200", $mTime);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
