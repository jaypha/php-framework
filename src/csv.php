<?php
//----------------------------------------------------------------------------
// Functions for use with CSV encoding
//----------------------------------------------------------------------------

namespace Jaypha;

const CSV_SLASHES = 1;
const CSV_DOUBLEQUOTES = 2;

//----------------------------------------------------------------------------

function csv_encode($value, $options = CSV_DOUBLEQUOTES)
{
  $output = [];

  foreach ($value as $row)
  {
    $line = [];
    //assert(\is_iterable($row));
    foreach ($row as $field)
      if ($field === "ID") // Special case for SYLK problem
        $line[] = '"ID"';
      else if ($options | CSV_DOUBLEQUOTES)
        $line[] = csv_escape_field_doublequotes($field);
      else if ($options | CSV_SLASHES)
        $line[] = csv_escape_field_slashes($field);
      else
        $line[] = $field;
    $output[] = implode(",",$line);
  }
  return implode("\n", $output);
}

//----------------------------------------------------------------------------

function csv_escape_field_doublequotes($value)
{
  if ((mb_strpos ($value, '"') !== False) || (mb_strpos ($value, ',') !== False) || (mb_strpos ($value, "\n") !== False) || (mb_strpos ($value, "\r") !== False))
    return '"'.str_replace ('"', '""', $value).'"';
  else
    return $value;
}

//----------------------------------------------------------------------------

function csv_escape_field_slashes($value)
{
  if ((mb_strpos ($value, '"') !== False) || (mb_strpos ($value, ',') !== False) || (mb_strpos ($value, "\n") !== False) || (mb_strpos ($value, "\r") !== False))
    return '"'.str_replace ('"', '\\"', str_replace ('\\', '\\\\', $value)).'"';
  else
    return $value;
}


//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
