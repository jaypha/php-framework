<?php
//----------------------------------------------------------------------------
// Authentication and authorisation functions
//----------------------------------------------------------------------------
// Authentication = Acknowledge identity
// Authorisation = Permission to do something.
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------

function actionAuthorized($actionList, User $actor, string $action, string $subjectId = null)
{
  // Superuser can do anything.
  if ($actor->isRoot())
    return true;

  $roles = $actor->roles;

  // No permission by default. Permission must be explicitly granted.
  if (!array_key_exists($action, $actionList))
    return false;

  foreach ($actionList[$action] as $r => $v)
  {
    if (!($roles & $r))
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


