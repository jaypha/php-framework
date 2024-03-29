<?php
//----------------------------------------------------------------------------
// Send input to a system application and retrieve its output.
//----------------------------------------------------------------------------

namespace Jaypha;

function pipe($cmd, $input, &$output)
{
  $descriptorspec =
  [
    0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
    1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
  ];

  $process = proc_open($cmd, $descriptorspec, $pipes);

  if (is_resource($process))
  {
    // $pipes now looks like this:
    // 0 => writeable handle connected to child stdin
    // 1 => readable handle connected to child stdout

    fwrite($pipes[0], $input);
    fclose($pipes[0]);

    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    $return_value = proc_close($process);

    return $return_value;
  }

  return false;
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
