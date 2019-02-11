<?php
//----------------------------------------------------------------------------
// Convenience function help setup time and date.
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

const DATE_SHORT = "j&\\n\b\s\p;M&\\n\b\s\p;y";
const DATE_LONG  = "jS&\\n\b\s\p;F&\\n\b\s\p;Y";
const DATE_COMMON = "jS&\\n\b\s\p;M&\\n\b\s\p;Y";
const DATE_MYSQL = "Y-m-d";
const DATE_BRIT  = "d/m/Y";
const TIME_MYSQL = "H:i:s";
const DATETIME_MYSQL = "Y-m-d H:i:s";
const DATETIME_COMMON = "jS&\\n\b\s\p;M&\\n\b\s\p;Y&\\n\b\s\p;&\\n\b\s\p;g:i&\\n\b\s\p;a";

function getTimezone()
{
  return $GLOBALS["timezone"] ?? null;
}

function date($dateStr)
{
  if ($dateStr == null) return null;
  return new \DateTime($dateStr, getTimezone());
}

function dateImmutable($dateStr)
{
  if ($dateStr == null) return null;
  return new \DateTimeImmutable($dateStr, getTimezone());
}

function today()
{
  return new \DateTime("today", getTimezone());
}

function todayImmutable()
{
  return new \DateTimeImmutable("today", getTimezone());
}

function now()
{
  return new \DateTime("now", getTimezone());
}

function nowImmutable()
{
  return new \DateTimeImmutable("now", getTimezone());
}

function formatDate(\DateTimeInterface $dateTime = null, $format = \DateTime::ISO8601, $nullIndicator = "-")
{
  if ($dateTime == null) return $nullIndicator;
  else return $dateTime->format($format);
}

// A test that restricts acceptable date strings to ISO format

function dateStrValid(string $str)
{
  if (preg_match("/^\d{4}-\d{2}-\d{2}$/",$str) == 1) return true;
  if (preg_match("/^\d{4}\d{2}\d{2}$/",$str) == 1) return true;
  return false;
}

// Takes in a date/time in any format and converts it to a DateTime value.

function toDateTime($timeValue = null)
{
  if ($timeValue === null)
    return now();
  if ($timeValue instanceof \DateTimeInterface)
    return $timeValue;
  if (is_string($timeValue))
  {
    if (ctype_digit($timeValue))
      $timeValue = (int) $timeValue;
    else
      return new \DateTime($timeValue, getTimezone());
  }
  assert(is_int($timeValue));
  $time = new \DateTime("now", getTimezone());
  $time->setTimestamp($timeValue);
  return $time;
}

// Convenience function to convert a date to MySQL format.

function toMysqlDate($date)
{
  $val = toDateTime($date);
  return $val->format(DATE_MYSQL);
}

function toMysqlTimestamp($time)
{
  $val = toDateTime($time);
  $val->setTimezone(new \DateTimeZone(\Config\MYSQL_TIMEZONE));
  return $val->format(DATETIME_MYSQL);
}

function toDateTimeString($date, $format = \DateTime::ISO8601)
{
  $val = toDateTime($date);
  return $val->format($format);
}

// Basically the number of years that have passed since $refDate.
function age($refDate, $ageDate = null)
{
  $diff = toDateTime($refDate)->diff(toDateTime($ageDate));

  return $diff->y;
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
