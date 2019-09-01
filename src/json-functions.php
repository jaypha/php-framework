<?php
//----------------------------------------------------------------------------
// Functions for use with JSON
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

function jsonReject($message, $code = null, $extra = [])
{
  $resp = [ "success" => false ];
  if ($message) $resp["message"] = $message;
  if ($code) $resp["code"] = $message;
  if ($extra) $resp = array_merge($resp, $extra);
  return $resp;
}

//----------------------------------------------------------------------------

function jsonSuccess($message, $extra = [])
{
  $resp = [ "success" => true ];
  if ($message) $resp["message"] = $message;
  if ($extra) $resp = array_merge($resp, $extra);
  return $resp;
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
