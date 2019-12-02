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

  foreach ($this->rules as $name => $rule)
  {
    $varType = $rule["type"] ?? "string";
    $default = $constraints["default"] ?? "";
    $isRequired = $constraints["required"] ?? false;
    switch ($varType)
    {
      case "id":
        $r = ExtractId::ExtractId($source, $resultsSoFar, $name, $isRequired);
        break;
      case "string":
        $r = ExtractText::ExtractText($source, $resultsSoFar, $name, $rule);
      case "enum":
      case "enumerated":
        $r = ExtractEnum::ExtractEnum($source, $resultsSoFar, $name, $rule);
        break;
      case "integer":
        $rule["precision"] = 0;
      case "number":
        $r = ExtractNumber::ExtractNumber($source, $resultsSoFar, $name, $rule);
        break;
      case "boolean":
      case "bool":
        $r = ExtractBoolean::ExtractBoolean($source, $resultsSoFar, $name, $isRequired, $default);
        break;
      default:
        throw new \LogicException("Type '$varType' not supported");
    }
  }
  return new ValidationResult($resultsSoFar);
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
