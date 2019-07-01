<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha\Middleware;
use Jaypha\Streams\StringInputStream;

class CsvOutput implements ResponseFactory, Middleware
{
  //function mimeType() { return "text/plain"; }
  function mimeType() { return "application/csv"; }

  function gracefulExit($code) { return null; }

  function reject($message, $code) { return null; }

  public function handle($input, Service $service)
  {
    $service->setResponseFactory($this);
    $output = $service->next($input);

    if ($output instanceof CsvDocument)
    {
      if ($output->filename)
        header("Content-Disposition: attachment; filename=\"$output->filename\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      return new StringInputStream($output->__toString());
    }
    else
    {
      assert(is_string($output) || $output instanceof InputStream);
      return $output;
    }
  }
}

//----------------------------------------------------------------------------

class CsvDocument
{
  public $filename;
  public $options = \Jaypha\CSV_DOUBLEQUOTES;

  private $data = [];

  private $currentRow;

  function __construct() { $this->addLine(); }
  function addCell($cell)
  {
    $this->currentRow->append($cell);
    return $this;
  }

  function addCells($cells)
  {
    assert(is_array($cells));
    foreach ($cells as $cell)
      $this->currentRow->append($cell);
    return $this;
  }

  function addLine($line = null)
  {
    if ($line !== null)
      $this->addCells($line);
    $this->currentRow = new \ArrayObject();
    $this->data[] = $this->currentRow;
    return $this;
  }

  function addLines($lines)
  {
    foreach ($lines as $line)
      $this->addLine($line);
    return $this;
  }

  function __toString() { return \Jaypha\csv_encode($this->data, $this->options); }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

