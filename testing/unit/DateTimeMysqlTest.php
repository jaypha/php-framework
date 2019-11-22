<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;

class DateTimeMysqlTest extends TestCase
{
  protected $date;
  protected $dateImmutable;
    
  function setUp()
  {
    $this->date = date("2018-01-01");
    $this->dateImmutable = dateImmutable("2018-01-01");
  }

  function testToMysqlDate()
  {
    $mDate = toMysqlDate(strtotime("2018-02-02"));
    $this->assertEquals("2018-02-02", $mDate);
  }

  function testToMysqlTimestamp()
  {
    $mTime = toMysqlTimestamp(strtotime("2018-02-02 +6hours +21minutes"));
    $this->assertEquals("2018-02-02 06:21:00", $mTime);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
