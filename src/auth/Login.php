<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

class Login
{
  static function get() : ?Login
  {
    if (isset($_SESSION["login"]))
      return new Login();
    else
      return null;
  }

  static function loginWithPassword(string $username, string $password, ?string $totpToken = null, int $roles = ROLES_ALL) : ?Login
  {
    global $rdb;
    if (isset($_SESSION["login"]))
      $_SESSION = [];
    $person = Person::getFromUsername($username);
    if (
      $person &&
      $person->hasRole($roles) &&
      $person->authenticate($password) &&
      $person->testTotpToken($totpToken)
    )
      return self::login($person);

    return null;
  }

  static function loginWithToken(string $token)
  {
    $stuff = processToken($token, "PHS-login");
    if (isFailure($stuff))
      return $stuff;
    $person = Person::get($stuff["sub"]);
    enforce($person != null);
    return self::login($person);
  }

  static function login(Person $person)
  {
    $login = new Login();
    $login->id = $person->id;
    $login->roles = $person->roles;
    $login->lastAccess = time();
    $login->expiry = \Config\LOGIN_TIMEOUT;
    return $login;
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
    $_SESSION = [];
  }

  function authenticate($password)
  {
    return $this->person->authenticate($password);
  }

  function actionAuthorised(string $action, string $subjectId = null)
  {
    return actionAuthorised(new Person($_SESSION["login"]), $action, $subjectId);
  }

  function getLoginToken()
  {
    return getToken($this->id, "PHS-login");
  }

  function __get($p)
  {
    if ($p == "person")
      return Person::get($_SESSION["login"]["id"]);
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
