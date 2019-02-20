<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
// Note: There is a C base PHP extension that does JWT, 
// https://github.com/cdoco/php-jwt
//----------------------------------------------------------------------------

namespace Jaypha;

use \Firebase\JWT\JWT;

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
  $currentPayload["exp"] = strtotime("+".\Config\JWT::RefreshTimeout);

  return JWT::encode($currentPayload, \Config\JWT_KEY);
}

function processToken($token, $aud)
{
  $payload = (array) JWT::decode($token, \Config\JWT_KEY, ["HS256"]);

  if ($payload["iss"] != \Config\JWT_ISS)
    return new Failure("Bad Issuer");

  if ($payload["aud"] != $aud)
    return new Failure("Bad Audience");

  if ($payload["exp"] < time())
    return new Failure("Expired");

  return $payload;    
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
