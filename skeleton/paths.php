<?php
//----------------------------------------------------------------------------
// Essential preliminaries to set up the include path.
// This file should be preincluded by the web server.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
namespace Config;

// Root directory for the application
const APP_ROOT = __DIR__;

\set_include_path(
  \implode(
    \PATH_SEPARATOR,
    [
      ".",
      __DIR__."/src",
      __DIR__."/src/framework",
    ]
  )
);

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
