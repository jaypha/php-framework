<?php
//----------------------------------------------------------------------------
// Function for GSM, using with SMS
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace PHS;

function gsm_strlen($content)
{
  $matches = array();
  $spec_count = preg_match_all("/[\[\]\^`{}|~\\\\]/",$content,$matches);
  assert($spec_count !== false);

  $count = strlen($content);

  return $count+$spec_count;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
