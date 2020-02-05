<?php
//----------------------------------------------------------------------------
// A script to run when the document is ready.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Jayponents\Html;

class DocReadyScript extends Script
{
  function displayInner()
  {
    echo "docReady.then(function(){";
    parent::displayInner();
    echo "});";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
