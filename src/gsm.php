<?php
//----------------------------------------------------------------------------
// Functions for GSM, for use with SMS
//----------------------------------------------------------------------------

namespace Jaypha;

function gsm_strlen($content)
{
  $matches = array();
  $spec_count = preg_match_all("/[\[\]\^`{}|~\\\\]/",$content,$matches);
  assert($spec_count !== false);

  $count = strlen($content);

  return $count+$spec_count;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
