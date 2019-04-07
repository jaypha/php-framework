<?php
//----------------------------------------------------------------------------
// Comparison function whose execution time is not dependant on string
// content
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

function timingSafeEquals(string $str1, string $str2) :bool
{
  $str1Len = strlen($str1);
  $str2Len = strlen($str2);

  if ($str1Len != $str2Len)
      return false;

  $result = 0;

  for ($i = 0; $i < $str1Len; $i++)
      $result |= (ord($str1[$i]) ^ ord($str2[$i]));

  return $result === 0;
}

//----------------------------------------------------------------------------
// Shamelessly ripped off from someone else.
// 
//
