<?php
//----------------------------------------------------------------------------
// Fundamental interfaces for extraction and validation.
//----------------------------------------------------------------------------
// Although commuonly called validation, these classes implements rules
// that both extract and validate values form a given source.
//
// This is why the main function is called extract and not validate
//----------------------------------------------------------------------------

namespace Jaypha;

interface ValidateRule
{
  function extract(iterable $source, iterable $resultsSoFar = []) : iterable;
  function setFailMessageFormat(string $code, string $format):  ValidateRule;
}

//----------------------------------------------------------------------------

interface ValidateRuleCollection extends ValidateRule
{
  function addRule(ValidateRule $rule) : ValidateRuleCollection;
}

//----------------------------------------------------------------------------

interface Evaluation
{
  function evaluate(iterable $resultsSoFar = []);
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
