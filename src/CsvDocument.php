<?php
//----------------------------------------------------------------------------
// CSV responses
//----------------------------------------------------------------------------

namespace Jaypha;

class CsvDocument
{
  public $filename;
  public $options = CSV_DOUBLEQUOTES;

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

  function __toString() { return csv_encode($this->data, $this->options); }
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//

