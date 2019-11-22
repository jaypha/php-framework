<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use PHPUnit\Framework\TestCase;

class IoTest extends TestCase
{
  const FILE_NAME = __DIR__."/text-for-io.txt";

  function readfile($f, $s, $c)
  {
    ob_start();
    readfilePartial($f,$s,$c);
    $x = ob_get_contents();
    ob_end_clean();
    return $x;
  }

  // Test parseHttpRangeHeader

  function testReadFile()
  {
    $this->assertEquals("",$this->readfile(self::FILE_NAME,12,0));
    $this->assertEquals("own",$this->readfile(self::FILE_NAME,12,3));
    $this->assertEquals("quick brown fox jump",$this->readfile(self::FILE_NAME,4,20));
    $this->assertEquals("The q",$this->readfile(self::FILE_NAME,0,5));
    $this->assertEquals("s over the lazy dog\n",$this->readfile(self::FILE_NAME,24,100));
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
