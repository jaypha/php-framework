<?php
//----------------------------------------------------------------------------
// Java Web Tokens
//----------------------------------------------------------------------------
// Note: There is a C base PHP extension that does JWT, 
// https://github.com/cdoco/php-jwt
//----------------------------------------------------------------------------

namespace Jaypha;

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

function getToken($sub, $aud, $timeout = null)
{
  $payload =
  [
    "iss" => \Config\JWT_ISS,
    "aud" => $aud,
    "iat" => time(),
    "exp" => strtotime("+".($timeout ?? \Config\JWT_TIMEOUT)),
    "sub" => $sub,
  ];
  return JWT::encode($payload, \Config\JWT_KEY);
}

function refreshToken(array $currentPayload = [])
{
  $currentPayload["iat"] = time();
  $currentPayload["exp"] = strtotime("+".\Config\JWT_TIMEOUT);

  return JWT::encode($currentPayload, \Config\JWT_KEY);
}

function processToken($token, $aud)
{
  try {
    $payload = (array) JWT::decode($token, \Config\JWT_KEY, ["HS256"]);
  } catch (ExpiredException $e) {
    return $e;
  }

  if ($payload["iss"] != \Config\JWT_ISS)
    return new \Exception("Bad Issuer");

  if ($payload["aud"] != $aud)
    return new \Exception("Bad Audience");

  if ($payload["exp"] < time())
    return new \Exception("Expired");

  return $payload;    
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
