<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use PHPUnit\Framework\TestCase;
use \PHS\File;

class FileTest extends TestCase
{
  const TestFile = "abcdefg";
  
  function testCreate()
  {
    $id = File::saveFile(
      self::TestFile,
      "me.txt",
      "text/plain",
      0
    );
    $f = File::get($id);
    $this->assertEquals($f->mimeType, "text/plain");
    $this->assertEquals($f->filename, "me.txt");
  }

  function testRead()
  {
    $id = File::saveFile(
      self::TestFile,
      "me.txt",
      "text/plain",
      0
    );
    $f = File::get($id);
    $this->assertEquals($f->getContents(), self::TestFile);
    $r = $f->getStream();
    $this->assertEquals(stream_get_contents($r), self::TestFile);
    fclose($r);
  }

  function testDelete()
  {
    $id = File::saveFile(
      self::TestFile,
      "me.txt",
      "text/plain",
      0
    );
    File::delete($id);
    $this->assertFalse(File::get($id));
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
