<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

use Psr\Http\Message\StreamInterface;

abstract class WrappedStream  implements StreamInterface
{
  private $_stream;

  public __construct(StreamInterface $stream)
  { $this->_stream = $srteam; }

  public function __toString() { return $this->_stream->__toString(); }

  public function close() { return $this->_stream->close(); }

  public function detach() { return $this->_stream->detach(); }

  public function getSize() { return $this->_stream->getSize(); }

  public function tell() { return $this->_stream->tell(); }

  public function eof() { return $this->_stream->eof(); }

  public function isSeekable() { return $this->_stream->isSeekable(); }

  public function seek($offset, $whence = SEEK_SET)
   { return $this->_stream->seek($offset, $whence); }

  public function rewind()  { return $this->_stream->rewind(); }

  public function isWritable()  { return $this->_stream->isWritable(); }

  public function write($string)  { return $this->_stream->write($string); }

  public function isReadable()  { return $this->_stream->isReadable(); }

  public function read($length)  { return $this->_stream->read($length); }

  public function getContents() { return $this->stream->getContents(); }

  public function getMetadata($key = null) { return $this->stream->getMetadata($key); }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
