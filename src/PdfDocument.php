<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class PdfDocument
{
  public $filename;
  public $content;

  function __toString()
  {
    if (is_object($this->content))
      return $this->content->__toString();
    else
    {
      assert(is_string($this->content));
      return $this->content;
    }
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
