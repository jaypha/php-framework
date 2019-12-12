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
    
  function setUp()
  {
  }

  function testToMysqlDate()
  {
    $this->assertNull(toMysqlDate(null));
    $mDate = toMysqlDate(strtotime("2018-02-02"));
    $this->assertEquals("2018-02-02", $mDate);
  }

  function testToMysqlTimestamp()
  {
    $this->assertNull(toMysqlTimestamp(null));
    $mTime = toMysqlTimestamp(strtotime("2018-02-02 +6hours +21minutes"));
    $this->assertEquals("2018-02-02 06:21:00", $mTime);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
