<?php
//----------------------------------------------------------------------------
// Path loader that uses the system include path settings
//----------------------------------------------------------------------------

namespace Jaypha;

class IncludePathFileLoader implements \Latte\ILoader
{
	function getContent($name)
	{
		$result = file_get_contents($name,true);
		if ($result === false)
		  throw new \RuntimeExcpetion("Failed to read template file '$name'.");
		return $result;
	}

	public function isExpired($file, $time)
	{
	  $fullPath = stream_resolve_include_path($file);
		$mtime = @filemtime($fullPath); // @ - stat may fail
		return !$mtime || $mtime > $time;
	}

	function getReferredName($name, $referringName)
	{
	  return $name;
	}

	function getUniqueId($name)
	{
	  return $name;
	}
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
