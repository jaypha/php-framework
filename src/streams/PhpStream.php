<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Psr\Http\Message\StreamInterface;

class PhpStream implements StreamInterface
{
  public $resource;

  function __construct($resource)
  {
    $this->resource = $resource;
  }

  public function __toString()
  {
    $uri = stream_get_meta_data($this->resource)["uri"];
    return get_file_contents($uri);
  }

  public function close() { fclose($this->resource); }

  public function detach() { return null; }

  public function getSize()
  {
    $uri = stream_get_meta_data($this->resource)["uri"];
    return filesize($uri);
  }

  public function tell() { return ftell($this->resource); }

  public function eof() { return feof($this->resource); }

  public function isSeekable() { return true; }

  public function seek($offset, $whence = SEEK_SET)
  {
    fseek($this->resource, $offset, $whence);
  }

  public function rewind()
  { rewind($this->resource); }

  public function isWritable()
  {
    $mode = stream_get_meta_data($this->resource)["mode"];
    return $mode != "r";
  }

  public function write($string)
  { fwrite($this->resource, $string); }

  public function isReadable()
  {
    $mode = stream_get_meta_data($this->resource)["mode"];
    return strpos($mode, "r") !== false || strpos($this->mode, "+") !== false;
  }

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
