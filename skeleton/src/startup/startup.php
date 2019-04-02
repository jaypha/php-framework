<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use Jaypha\Middleware as MW;

require \Config\APP_ROOT."/vendor/autoload.php";
require \Config\APP_ROOT."/config.php";

require "require.php";

$service = (new MW\Service(new \Jaypha\DevLogger()))
           ->add(new MW\IEDetect())
           ->add(new MW\Timezone())
//           ->add(new MW\Database())
//           ->add(new MW\ContentSecurityPolicyReportOnly([
//            "default-src" => [ "'self'" ],
//            "style-src" => [ "'self'", "'unsafe-inline'" ],
//            "script-src" => [ "'self'", "'unsafe-inline'" ],
//            "report-uri" => "/csp/report.php"
//           ]))
;

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
