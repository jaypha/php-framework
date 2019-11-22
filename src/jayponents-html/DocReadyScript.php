<?php
//----------------------------------------------------------------------------
// A script to run when the document is ready.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

use Jaypha\Jayponents\Html;

class DocReadyScript extends Html\Script
{
  function displayInner()
  {
    echo "docReady.then(function() {\n";
    parent::displayInner();
    echo "});\n";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-19 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
