<?php
//----------------------------------------------------------------------------
// Convenience function for time and date with a MySQL databgse
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

const DATE_MYSQL = "Y-m-d";
const TIME_MYSQL = "H:i:s";
const DATETIME_MYSQL = "Y-m-d H:i:s";

//---------------------------------------------------------------------------
// Convenience function to convert a date to MySQL format.

function toMysqlDate($date)
{
  if ($date == null) return null;
  $val = toDateTime($date);
  return $val->format(DATE_MYSQL);
}

function toMysqlTimestamp($time)
{
  if ($time == null) return null;
  $val = toDateTime($time);
  $val->setTimezone(new \DateTimeZone(\Config\MYSQL_TIMEZONE));
  return $val->format(DATETIME_MYSQL);
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
