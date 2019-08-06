<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class SetContentSecurityPolicy implements Middleware
{
  function __construct($policies, $reportOnly = false)
  {
    $this->policies = $policies;
    $this->headerName = $reportOnly ?
                        "Content-Security-Policy-Report-Only" :
                        "Content-Security-Policy";
  }
    
  public function handle($input, Service $service)
  {
    $policyStr = [];
    foreach ($this->policies as $i => $v)
    {
      if (is_array($v))
        $policyStr[] = "$i ".implode(" ", $v);
      else
        $policyStr[] = "$i $v";
    }
    header($this->headerName.": ".implode("; ",$policyStr));
    return $service->next($input);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
