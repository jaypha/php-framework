<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;

class ContentSecurityPolicy implements Middleware
{
  function __construct($policies)
  {
    $this->policies = $policies;
    $this->headerName = "Content-Security-Policy";
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

class ContentSecurityPolicyReportOnly extends ContentSecurityPolicy
{
  function __construct($policies)
  {
    parent::__construct($policies);
    $this->headerName = "Content-Security-Policy-Report-Only";
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
