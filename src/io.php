<?php
//----------------------------------------------------------------------------
// Extra functions for I/O
//----------------------------------------------------------------------------

namespace Jaypha;

const RFP_BUFFER_SIZE = 1024*64;

//----------------------------------------------------------------------------
// Similar to 'readfile', except it reads a portion of it.
// TODO add support for other readfile parameters
// TODO add default for $limit
// TODO add support for offset from end of file

function readfilePartial($filename, $offset, $limit)
{
  $l = ini_get("max_execution_time");
	$fp = fopen($filename, 'rb');
  fseek($fp, $offset);
  $c = 0;

	while(!feof($fp) && ($c < $limit))
	{
	  if ($c + RFP_BUFFER_SIZE > $limit)
      echo fread($fp, $limit-$c);
	  else
      echo fread($fp, RFP_BUFFER_SIZE);
    $c += RFP_BUFFER_SIZE;
		set_time_limit($l); // Don't timeout for big files.
		flush(); // Free up memory.
	}
	fclose($fp);
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
