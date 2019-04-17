<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
  protected $date;
  protected $dateImmutable;
    
  function setUp()
  {
    $this->date = \PHS\date("2018-01-01");
    $this->dateImmutable = \PHS\dateImmutable("2018-01-01");
  }

  function testFromNull()
  {
    $this->assertNull(\PHS\date(null));
    $this->assertNull(\PHS\dateImmutable(null));
  }

  function testType()
  {
    $this->assertInstanceOf(\DateTime::class, $this->date);
    $this->assertInstanceOf(\DateTimeImmutable::class, $this->dateImmutable);
  }

  function testStrValid()
  {
    $this->assertTrue(\PHS\dateStrValid("2018-02-02"));
    $this->assertTrue(\PHS\dateStrValid("20180202"));
    $this->assertFalse(\PHS\dateStrValid("20-12-0202"));
    $this->assertFalse(\PHS\dateStrValid("xyz"));
    $this->assertFalse(\PHS\dateStrValid(""));
  }

  function toDateTime()
  {
    $date = \PHS\toDateTime(strtotime("2018-02-02"));
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date->format(\PHS\DATE_MYSQL) == "2018-02-02");
    
    $date = \PHS\toDateTime("2018-02-02");
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date->format(\PHS\DATE_MYSQL) == "2018-02-02");

    $date = \PHS\toDateTime();
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date == \PHS\now());

    $date = \PHS\today();
    $this->assertInstanceOf(\DateTime::class, $date);
    $this->assertTrue($date == \PHS\toDateTime($date));
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
