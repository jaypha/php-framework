<?php
//----------------------------------------------------------------------------
// Error handling gunk.
//----------------------------------------------------------------------------

//----------------------------------------------------------------------------
// Logger

  $logger = new \Jaypha\NullLogger();

  function setLogger($logger) {
    assert ($logger instanceof \Psr\Log\LoggerInterface);
    $GLOBALS["logger"] = $logger;
  }
  function getLogger() { return $GLOBALS["logger"]; }

//----------------------------------------------------------------------------
// Graceful Exit

  $gracefulExitOutput = function($code) {};
    
  function setGracefulExitOutput($callable)
  {
    assert (is_callable($callable));
    $GLOBALS["gracefulExitOutput"] = $callable;
  }

  function gracefulExit($code = 500)
  {
    global $gracefulExitOutput;
    http_response_code($code);
    $gracefulExitOutput($code);
    exit;
  }

//----------------------------------------------------------------------------

  function getDebuggingInfo(Throwable $exception)
  {
    $text = "-- Error Description -------------------------\n".
            $exception->__toString().
            "\n----------------------------------------------\n";
    if (isset($_SERVER['HTTP_HOST']))
      $text .= "URL: ".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."\n";
    else
      $text .= "No Host\n";
    if (isset($_SESSION) && count($_SESSION))
      $text .= "\n--- Session ---\n".print_r($_SESSION, true)."\n";
    if (isset($_GET) && count($_GET))
      $text .= "\n--- Get ---\n".print_r($_GET, true)."\n";
    if (isset($_POST) && count($_POST))
      $text .= "\n--- Post ---\n".print_r($_POST, true)."\n";
    //if (isset($_SERVER) && count($_SERVER))
    //  $text.= "\n--- Server ---\n".serialize($_SERVER)."\n";
    return $text;
  }

//----------------------------------------------------------------------------
// Quick functions
//----------------------------------------------------------------------------

  function debug(string $message)
  {
    getLogger()->debug($message);
  }

  //--------------------------------------------------------------------------
  // Records a warning that only needs to be logged

  function warn(string $message)
  {
    getLogger()->warning($message);
  }

  //--------------------------------------------------------------------------
  // Non-critical error that requires notification

  function error(string $message)
  {
    getLogger()->error($message);
  }

  //--------------------------------------------------------------------------
  // Critical error that requires quitting

  function critical(string $message)
  {
    if ($message == "")
      errorWithDetails(new Exception("No message given"));
    else
      getLogger()->critical($message);
    gracefulExit();
  }

  //--------------------------------------------------------------------------
  // Creates a critical error with extra debugging details

  function errorWithDetails(Throwable $exception)
  {
    critical(getDebuggingInfo($exception));
  }

//----------------------------------------------------------------------------
// Handler for PHP errors

  function phpError($errno, $errstr, $errfile, $errline)
  {
    if (!(error_reporting() & $errno)) return true;

	  $labels = [
		  E_ERROR           => 'E_ERROR',
		  E_WARNING         => 'E_WARNING',
		  E_PARSE           => 'E_PARSE',
		  E_NOTICE          => 'E_NOTICE',
		  E_CORE_ERROR      => 'E_CORE_ERROR',
		  E_CORE_WARNING    => 'E_CORE_WARNING',
		  E_COMPILE_ERROR   => 'E_COMPILE_ERROR',
		  E_COMPILE_WARNING => 'E_COMPILE_WARNING',
		  E_USER_ERROR      => 'E_USER_ERROR',
		  E_USER_WARNING    => 'E_USER_WARNING',
		  E_USER_NOTICE     => 'E_USER_NOTICE',
		  E_STRICT          => 'E_STRICT',
		  E_RECOVERABLE_ERROR  => 'E_RECOVERABLE_ERROR',
		  E_DEPRECATED      => "E_DEPRECATED",
		  E_USER_DEPRECATED => "E_USER_DEPRECATED"
	  ];

    if (\Config\DEBUG)
      errorWithDetails(new Exception("Error {$labels[$errno]} - $errstr ($errfile, $errline)"));
    else
      warn("Error {$labels[$errno]} - $errstr ($errfile, $errline)");
	  return true;
  }

  function setErrorHandlers()
  {
    set_error_handler("phpError");
    set_exception_handler("errorWithDetails");
  }

//-----------------------------------------------------------------------------
// Checking functions.
//-----------------------------------------------------------------------------

  //---------------------------------------------------------------------------
  // Checks for a condition. If it fails, execution quits immediately without
  // logging.

  function guard($condition)
  {
    if (!$condition) exit;
  }

  //---------------------------------------------------------------------------
  // Checks for a condition. If it fails, execution quits gracefully.

  function enforce($condition, $message = "")
  {
    if (!((bool)$condition))
      critical($message);
  }

  //---------------------------------------------------------------------------
  // Checks for a condition. If it fails, execution continues.

  function check($condition, $message = "")
  {
    if (!((bool)$condition))
      error($message);
  }

  //---------------------------------------------------------------------------
  // instant quit with and optional code.

  function quit($code = 500)
  {
    http_response_code($code);
    exit;
  }

//-----------------------------------------------------------------------------
// Easy redirect

  function redirect($url)
  {
    header("Location: $url");
    exit();
  }

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
