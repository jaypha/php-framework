<?php
//----------------------------------------------------------------------------
// Convenience function for time and date.
//----------------------------------------------------------------------------
// Use with the Timezone middleware
//----------------------------------------------------------------------------

namespace Jaypha;

const DATE_SHORT = "j&\u{00a0}M\u{00a0}y";
const DATE_LONG  = "jS\u{00a0}F\u{00a0}Y";
const DATE_COMMON = "jS\u{00a0}M\u{00a0}Y";
const DATE_MYSQL = "Y-m-d";
const DATE_BRIT  = "d/m/Y";
const TIME_MYSQL = "H:i:s";
const DATETIME_MYSQL = "Y-m-d\u{00a0}H:i:s";
const DATETIME_COMMON = "jS\u{00a0}M\u{00a0}Y\u{00a0}\u{00a0}g:i\u{00a0}a";

//---------------------------------------------------------------------------

// It would be preferable to be able to set the default timezone.
// Unfortunately you cannot set the default to an offset (eg '+0200')

function setTimezone($tz)
{
  if ($tz === null)
    $GLOBALS["jaypha_timezone"] = new \DateTimeZone(\date_default_timezone_get());
  else if (is_string($tz))
    $GLOBALS["jaypha_timezone"] = new \DateTimeZone($tz);
  else
  {
    assert($tz instanceof \DateTimeZone);
    $GLOBALS["jaypha_timezone"] = $tz;
  }
}

function getTimezone()
{
  assert(!isset($GLOBALS["jaypha_timezone"]) || $GLOBALS["jaypha_timezone"] instanceof \DateTimeZone);
  return $GLOBALS["jaypha_timezone"] ?? new \DateTimeZone(\date_default_timezone_get());
}

//---------------------------------------------------------------------------

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

function formatDate($dateTime = null, $format = \DateTime::ISO8601, $nullIndicator = "-")
{
  return formatDateTime($dateTime, $format, $nullIndicator);
}

function formatDateTime($dateTime = null, $format = \DateTime::ISO8601, $nullIndicator = "-")
{
  if ($dateTime == null) return $nullIndicator;
  else return toDateTime($dateTime)->format($format);
}

// A test that restricts acceptable date strings to ISO format

function dateStrValid(string $str)
{
  if (preg_match("/^\d{4}-\d{2}-\d{2}$/",$str) == 1) return true;
  if (preg_match("/^\d{4}\d{2}\d{2}$/",$str) == 1) return true;
  return false;
}

//---------------------------------------------------------------------------
// Takes in a date/time in any format and converts it to a DateTime value.

function toDateTime($timeValue = null)
{
  if ($timeValue === null)
    return now();
  if ($timeValue instanceof \DateTime)
    return $timeValue;
  if ($timeValue instanceof \DateTimeImmutable)
    return new \DateTime($timeValue->format(\DateTimeInterface::ISO8601));
  if (is_string($timeValue) && !ctype_digit($timeValue))
    return new \DateTime($timeValue, getTimezone());
  assert(is_int($timeValue) || ctype_digit($timeValue));
  $time = new \DateTime("@$timeValue");
  return $time->setTimezone(getTimezone());
}

//---------------------------------------------------------------------------
// Same as above, except DateTimeImmutable

function toDateTimeImmutable($timeValue = null)
{
  if ($timeValue === null)
    return nowImmutable();
  if ($timeValue instanceof \DateTimeImmutable)
    return $timeValue;
  if ($timeValue instanceof \DateTime)
    return \DateTimeImmutable::createFromMutable($timeValue);
  if (is_string($timeValue) && !ctype_digit($timeValue))
    return new \DateTimeImmutable($timeValue, getTimezone());
  assert(is_int($timeValue) || ctype_digit($timeValue));
  $time = new \DateTimeImmutable("@$timeValue");
  return $time->setTimezone(getTimezone());
}

//---------------------------------------------------------------------------
// Convenience function to convert a date to MySQL format.

function toMysqlDate($date = null)
{
  $val = toDateTime($date);
  return $val->format(DATE_MYSQL);
}

function toMysqlTimestamp($time = null)
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
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
