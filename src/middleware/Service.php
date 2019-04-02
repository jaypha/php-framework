<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha\Middleware {

use Jaypha\NullLogger;

use Psr\Log\LoggerInterface;

class Service
{
  static $service = null;

  private $stack = [];
  private $stackIdx = 0;
  public $logger;

  public $responseFactory = null;
  private $gracefulExit = null;

  function __construct(?LoggerInterface $logger = null)
  { 
    assert(self::$service == null);
    if ($logger) $this->logger = $logger;
    else $this->logger = new NullLogger();
    self::$service = $this;
    set_exception_handler("errorWithDetails");
    set_error_handler("phpError");
  }

  function add($middleware)
  {
    $this->stack[] = $middleware;
    return $this;
  }

  function push($middleware)
  {
    array_unshift($this->stack[], $middleware);
    return $this;
  }

  function run($middleware = null)
  {
    if ($middleware) $this->add($middleware);
    $input = $_REQUEST;
    $output = $this->next($input);
    echo $output;
  }

  public function setResponseFactory(ResponseFactory $responseFactory)
  {
    $this->responseFactory = $responseFactory;
    header("Content-Type: ".$responseFactory->mimeType());
    return $this;
  }

  public function next($input)
  {
    $current = $this->stack[$this->stackIdx++];
    if (is_callable($current))
      return $current($input, $this);
    else
      return $current->handle($input, $this);
  }

  static function quitGraceful($code = 500)
  {
    http_response_code($code);
    if (self::$service->responseFactory)
      self::$service->responseFactory->gracefulExit($code);
    //if (self::$service && is_callable(self::$service->gracefulExit))
    //  (self::$service->gracefulExit)($message, $code);
    exit;
  }

  static function quit($code = 400)
  {
    http_response_code($code);
    exit;
  }
}

}

//----------------------------------------------------------------------------
// Error handling gunk.
//----------------------------------------------------------------------------

namespace {

use Jaypha\Middleware\Service;

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
    $text .= "\n--- Session ---\n".serialize($_SESSION)."\n";
  if (isset($_GET) && count($_GET))
    $text .= "\n--- Get ---\n".serialize($_POST)."\n";
  if (isset($_POST) && count($_POST))
    $text .= "\n--- Post ---\n".serialize($_POST)."\n";
  if (isset($_SERVER) && count($_SERVER))
    $text.= "\n--- Server ---\n".serialize($_SERVER)."\n";
  return $text;
}

//----------------------------------------------------------------------------
// Quick functions
//----------------------------------------------------------------------------

  function debug(string $message)
  {
    if (Service::$service)
      Service::$service->logger->debug($message);
  }

  //--------------------------------------------------------------------------
  // Records a warning that only needs to be logged

  function warn(string $message)
  {
    if (Service::$service)
      Service::$service->logger->warning($message);
  }

  //--------------------------------------------------------------------------
  // Non-critical error that requires notification

  function error(string $message)
  {
    if (Service::$service)
      Service::$service->logger->error($message);
  }

  //--------------------------------------------------------------------------
  // Critical error that requires quitting

  function critical(string $message)
  {
    if (Service::$service)
      Service::$service->logger->critical($message);
    Service::quitGraceful();
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
		//E_ERROR           => 'E_ERROR',
		E_WARNING         => 'E_WARNING',
		//E_PARSE           => 'E_PARSE',
		E_NOTICE          => 'E_NOTICE',
		//E_CORE_ERROR      => 'E_CORE_ERROR',
		//E_CORE_WARNING    => 'E_CORE_WARNING',
		//E_COMPILE_ERROR   => 'E_COMPILE_ERROR',
		//E_COMPILE_WARNING => 'E_COMPILE_WARNING',
		E_USER_ERROR      => 'E_USER_ERROR',
		E_USER_WARNING    => 'E_USER_WARNING',
		E_USER_NOTICE     => 'E_USER_NOTICE',
		E_STRICT          => 'E_STRICT',
		E_RECOVERABLE_ERROR  => 'E_RECOVERABLE_ERROR',
		//E_DEPRECATED      => "E_DEPRECATED",
		E_USER_DEPRECATED => "E_USER_DEPRECATED"
	];

  warn("Error {$labels[$errno]} - $errstr ($errfile, $errline)");
	return true;
}

//-----------------------------------------------------------------------------


//-----------------------------------------------------------------------------
// Checking functions.
//-----------------------------------------------------------------------------

  //---------------------------------------------------------------------------
  // Checks for a condition. If it fails, execution quits immediately without
  // logging.

  function guard($condition, $code = 400)
  {
    if (!$condition)
      Service::quit($code);
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

}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
