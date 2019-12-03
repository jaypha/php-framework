<?php
//----------------------------------------------------------------------------
// A simple and quick validator/extractor that uses a list of rules
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

function extractValues($source, $rules)
{
  $resultsSoFar = [];

  foreach ($rules as $name => $rule)
  {
    $varType = $rule["type"] ?? "string";
    $default = $constraints["default"] ?? "";
    $isRequired = $constraints["required"] ?? false;
    switch ($varType)
    {
      case "id":
        $resultsSoFar = ExtractId::ExtractId($source, $resultsSoFar, $name, $isRequired);
        break;
      case "string":
        $resultsSoFar = ExtractText::ExtractText($source, $resultsSoFar, $name, $rule);
      case "enum":
      case "enumerated":
        $resultsSoFar = ExtractEnum::ExtractEnum($source, $resultsSoFar, $name, $rule);
        break;
      case "integer":
        $rule["precision"] = 0;
      case "number":
        $resultsSoFar = ExtractNumber::ExtractNumber($source, $resultsSoFar, $name, $rule);
        break;
      case "boolean":
      case "bool":
        $resultsSoFar = ExtractBoolean::ExtractBoolean($source, $resultsSoFar, $name, $isRequired, $default);
        break;
      default:
        throw new \LogicException("Type '$varType' not supported");
    }
  }
  return new ValidationResult($resultsSoFar);
}

/*----------------------------------------------------------------------------

 Validation constraint parameters.
 
 For all types
  type
  required
  default

 For string
  maxLength
  minLength
  pattern

 For enum
  options
  maxCount
  minCount

 For integer
  min
  max

 For number
  min
  max
  precision

*/

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
