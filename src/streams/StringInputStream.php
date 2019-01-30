<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Streams;

use Psr\Http\Message\StreamInterface;

class StringInputStream implements StreamInterface
{
  public $str;
  public $idx = 0;

  function __construct($s)
  {
    if (is_object($s))
      $this->str = $s->__toString();
    else
      $this->str = (string) $s;
    $this->length = strlen($s);
  }

  public function __toString()
  {
    return $this->str;
  }

  public function close() {}

  public function detach() { return null; }

  public function getSize() { return $this->length; }

  public function tell() { return $this->idx; }

  public function eof() { return $this->idx >= $this->length; }

  public function isSeekable() { return true; }

  public function seek($offset, $whence = SEEK_SET)
  {
    switch ($whence)
    {
      case SEEK_SET:
        $this->idx = $offset;
        break;
      case SEEK_CUR:
        $this->idx += $offset;
        break;
      case SEEK_END:
        $this->idx = strlen($this->str) + $offset;
        break;
      default:
        throw new RuntimeException("'whence' value $whence not supported");
    }
  }

  public function rewind()
  { $this->idx = 0; }

  public function isWritable() { return false; }

  public function write($string)
  { throw new RuntimeException("Not writable"); }

  public function isReadable() { return true; }

  public function read($length)
  {
    $idx = $this->idx;
    $this->idx+=$length;
    return substr($this->str, $this->idx, $length);
  }

  public function getContents() { return substr($this->str, $this->idx); }

  public function getMetadata($key = null) { return null; }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
