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
  }

  function testFromNull()
  {
    $this->assertNull(date(null));
    $this->assertNull(dateImmutable(null));
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
    $date = toDateTime(strtotime("2018-02-02"));
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date->format(DATE_MYSQL) == "2018-02-02");
    
    $date = toDateTime("2018-02-02");
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date->format(DATE_MYSQL) == "2018-02-02");

    $date = toDateTime();
    $this->assertInstanceOf(\DateTime::class, $date);

    $date = today();
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date == toDateTime($date));
  }

  function testToMysqlDate()
  {
  }

  function testToMysqlTimestamp()
  {
  }

  function testToDateTimeString()
  {
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
