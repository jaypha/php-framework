<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

require __DIR__."/.startup.php";

//----------------------------------------------------------------------------

echo "1\n";
guard(true);
echo "2\n";
guard(4-3 == 1);
echo "3\n";
guard(false);
echo "4\n";

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//