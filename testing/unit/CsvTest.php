<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use PHPUnit\Framework\TestCase;

class CsvTest extends TestCase
{
  function testCsvEncode()
  {
    $input =
    [
      [ "ID", "John", 213, "\"extra", "bill\n" ],
      [],
      [ 14, "yay!" ]
    ];
    $expected = "\"ID\",John,213,\"\"\"extra\",\"bill\n\"\n\n14,yay!";
    $output = \PHS\csv_encode($input);
    $this->assertEquals($output, $expected);
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
