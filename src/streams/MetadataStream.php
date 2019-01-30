<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

class MetadataStream extends WrappedStream
{
  private $metaData = [];

  public function getMetadata($key = null) {
  {
    if ($key)
      return $this->metaData[$key] ?? null;
    else
      return $this->metaData;
  }

  public function setMetadata($v, $key = null) {
  {
    if ($key)
      $this->metaData[$key] = $v;
    else
      $this->metaData = $v;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
