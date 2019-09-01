<?php
//----------------------------------------------------------------------------
// Handles login session
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class Login
{
  private $_user = null;
  private $factory;

  static function isLoggedIn()
  {
    return (isset($_SESSION["login"]));
  }

  function __construct(UserFactory $f)
  {
    $this->factory = $f;
    if (isset($_SESSION["login"]))
      $this->_user = $f->get($_SESSION["login"]["id"]);
  }

  function loginWithPassword(string $username, string $password, ?string $totpToken = null)
  {
    if ($this->isLoggedIn())
      $this->logout();
    $user = $this->factory->getFromUsername($username);
    if (
      $user &&
      $user->actionAuthorised("login") &&
      $user->authenticate($password) &&
      $user->testTotpToken($totpToken)
    )
      return $this->login($user);

    return false;
  }

  function loginWithToken(string $token)
  {
    $stuff = processToken($token, \Config\TOKEN_AUD_LOGIN);
    if ($stuff instanceof \Exception)
      return $stuff;
    $user = $this->factory->get($stuff["sub"]);
    enforce($user != null);
    return $this->login($user);
  }

  function login(User $user)
  {
    $this->_user = $user;
    $this->id = $user->id;
    $this->lastAccess = time();
    $this->expiry = \Config\LOGIN_TIMEOUT;
    return true;
  }

  function touch()
  {
    $this->lastAccess = time();
  }

  function isExpired()
  {
    return $this->lastAccess + $this->expiry < time();
  }

  function logout()
  {
    unset($_SESSION["login"]);
    $this->_user = null;
  }

  function authenticate($password)
  {
    return $this->_user->authenticate($password);
  }

  function actionAuthorised($action, $subjectId = null)
  {
    return $this->_user->actionAuthorised($action, $subjectId);
  }

  function getLoginToken()
  {
    return getToken($this->id, \Config\TOKEN_AUD_LOGIN);
  }

  function __get($p)
  {
    if ($p == "user")
      return $this->_user;
    assert(isset($_SESSION["login"][$p]));
    return $_SESSION["login"][$p];
  }

  function __set($p, $v)
  {
    $_SESSION["login"][$p] = $v;
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
