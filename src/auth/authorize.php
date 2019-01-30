<?php
//----------------------------------------------------------------------------
// Authentication and authorisation functions
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------
// Authorisation - Permission to do something.
//----------------------------------------------------------------------------

function actionAuthorized(Person $actor, string $action, string $subjectId = null)
{
  // Superuser can do anything.
  if ($actor->isRoot())
    return true;

  $roles = $actor->roles;

  // No permission by default. Permission must be explicitly granted.
  if (!array_key_exists($action, ACTION_LIST))
    return false;

  foreach (ACTION_LIST[$action] as $r => $v)
  {
    if (!includesRole($roles, $r))
      continue;
    if ($v === true)
      return true;
    else
      return $v($subjectId, $actor->id);
  }

  return false;
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//


