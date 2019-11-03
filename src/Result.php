<?php
//----------------------------------------------------------------------------
// Basic result type to return a value along with a success/fail status.
//----------------------------------------------------------------------------

namespace Jaypha;


class Result
{
  public $success;
  public $code = null;
  public $message = null;
  public $payload = null;

  static function success($payload)
  {
    $r = new Result();
    $r->success = true;
    $r->payload = $payload;
    return $r;
  }

  static function fail($code, ?string $message = null, $payload = null)
  {
    $r = new Result();
    $r->code = $code;
    $r->success = false;
    $r->message = $message;
    $r->payload = $payload;
    return $r;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
