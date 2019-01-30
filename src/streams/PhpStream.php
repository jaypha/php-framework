<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Streams;

use Psr\Http\Message\StreamInterface;

class PhpStream implements StreamInterface
{
  public $resource;
  public $handle;
  public $mode;

  function __construct($handle, $mode)
  {
    $this->handle = $handle;
    $this->mdoe = $mode;
    $this->resource = fopen($handle, $mode);
  }

  public function __toString()
  {
    return get_file_contents($this->handle);
  }

  public function close() { fclose($this->resource); }

  public function detach() { return null; }

  public function getSize() { return filesize($this->handle); }

  public function tell() { return ftell($this->resource); }

  public function eof() { return feof($this->resource); }

  public function isSeekable() { return true; }

  public function seek($offset, $whence = SEEK_SET)
  {
    fseek($this->resource, $offset, $whence);
  }

  public function rewind()
  { rewind($this->resource); }

  public function isWritable() { return ($this->mode != "r"); }

  public function write($string)
  { fwrite($this->resource, $string); }

  public function isReadable() { return strpos($this->mode, "r") !== false || strpos($this->mode, "+") !== false; }

  public function read($length)
  {
    return fread($this->resource, $length);
  }

  public function getContents() { return stream_get_contents($this->resource); }

  public function getMetadata($key = null) { return null; }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
