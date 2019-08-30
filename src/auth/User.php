<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

interface UserFactory
{
  function get($id) : ?User;
  function getFromUsername(string $username) : ?User;
  function create(string $username, string $password = null, bool $generateKey = false) : ?User;
}

interface User
{
  function isRoot() : bool;
  function authenticate($password) : bool;
  function actionAuthorised($action, $subjectId = null) : bool;
  function testTotpToken($token) : bool;
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
