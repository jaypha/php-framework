<?php
//----------------------------------------------------------------------------
// Essential preliminaries to set up the include path.
// Used for testing.
//----------------------------------------------------------------------------

const APP_ROOT = __DIR__;

$paths =
[
  ".",
  __DIR__."/src"
];

set_include_path(implode(PATH_SEPARATOR,$paths));

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
