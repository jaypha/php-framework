<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

namespace Jaypha;

//----------------------------------------------------------------------------
// The sequce is an array. Each item is an assoc with the following fields
// - name - the name of the step
// - test - a test function to see if the step must be taken.
// - any other desired fields.
//----------------------------------------------------------------------------

interface ISteps
{
  function start();
  function stop();
  function numSteps() : int;
  function currentStep() : ?int;
  function furthestStep() : ?int;
  function isCurrentStep($name) : bool;
  function advanceStep() : ?int;
  function reverseStep() : ?int;
  function gotoStep(int $n) : bool;
  function getContentForStep(?int $n = null); // Defaults to current step
}

//----------------------------------------------------------------------------
// A momento is a design pattern where the storage code is separate from the
// object code.

interface IStepMomento
{
  function getSteps();
  function updateSteps($currentStep, $furthestStep);
}

//----------------------------------------------------------------------------

class Steps implements ISteps
{
  private $sqequnce;
  private $momento;

  private $currentStep;
  private $furthestStep;

  //-------------------------------------------------------

  function __construct($sequence, $momento = null)
  {
    $this->sequence = $sequence;
    $this->momento = $momento;
    if ($momento)
    {
      $t = $momento->getSteps();
      $this->currentStep = $t["currentStep"];
      $this->furthestStep = $t["furthestStep"];
    }
  }

  //-------------------------------------------------------

  function start()
  {
    $this->currentStep = 0;
    $this->furthestStep = 0;
    $this->updateMomento();
  }

  //-------------------------------------------------------

  function stop()
  {
    $this->currentStep = null;
    $this->furthestStep = null;
    $this->updateMomento();
  }

  //-------------------------------------------------------

  function numSteps() : int
  {
    return count($this->sequence);
  }

  //-------------------------------------------------------

  function currentStep() : ?int
  {
    return $this->currentStep;
  }

  //-------------------------------------------------------

  function isCurrentStep($name) : bool
  {
    if (isset($this->sequence[$this->currentStep]["name"]))
      return $this->sequence[$this->currentStep]["name"] == $name;
    else
      return false;
  }

  //-------------------------------------------------------

  function furthestStep() : ?int
  {
    return $this->furthestStep;
  }

  //-------------------------------------------------------

  function advanceStep() : ?int
  {
    if ($this->currentStep !== null)
    {
      do {
        ++$this->currentStep;
        if (isset($this->sequence[$this->currentStep]["test"]))
          $mustDo = $this->sequence[$this->currentStep]["test"]();
        else
          $mustDo = true;
      } while (!$mustDo);

      if ($this->currentStep > $this->furthestStep)
        $this->furthestStep = $this->currentStep;
      if ($this->currentStep >= count($this->sequence))
      {
        $this->stop();
        return null;
      }
      $this->updateMomento();
      return $this->currentStep;
    }
    return null;
  }

  //-------------------------------------------------------

  function reverseStep() : ?int
  {
    if ($this->currentStep !== null)
    {
      --$this->currentStep;
      if ($this->currentStep < 0)
        $this->currentStep = 0;
      $this->updateMomento();
      return $this->currentStep;
    }
    return null;
  }

  //-------------------------------------------------------

  function gotoStep(int $n) : bool
  {
    if ($this->currentStep !== null && $n <= $this->furthestStep)
    {
      $this->currentStep = $n;
      $this->updateMomento();
      return true;
    }
    return false;
  }

  //-------------------------------------------------------

  function getContentForStep(?int $n = null) // Defaults to current step
  {
    if ($this->currentStep === null)
      return null;

    if ($n === null)
      $n = $this->currentStep;

    assert(isset($this->sequence[$n]));
    return $this->sequence[$n];
  }

  //-------------------------------------------------------

  private function updateMomento()
  {
    if ($this->momento)
      $this->momento->updateSteps($this->currentStep, $this->furthestStep);
  }
}


//----------------------------------------------------------------------------
// Stores the step state in the session

class SessionStepMomento
{
  private $name;

  function __construct($name)
  {
    $this->name = $name;
    if (!isset($_SESSION["steps"][$name]))
      $_SESSION["steps"][$name] = [ "currentStep" => null, "furthestStep" => null ];
  }

  function getSteps()
  {
    return $_SESSION["steps"][$this->name];
  }

  function updateSteps($currentStep, $furthestStep)
  {
    $_SESSION["steps"][$this->name] = [ "currentStep" => $currentStep, "furthestStep" => $furthestStep ];
  }
}

//----------------------------------------------------------------------------
// Stores the step state in a database table.

class DbStepMomento
{
  private $tableName, $rdb, $id;

  function __construct($tableName, $rdb, int $id)
  {
    $this->tableName = $tableName;
    $this->rdb = $rdb;
    $this0->id = $id;
  }

  function getSteps()
  {
    return $this->rdb->queryRow("select currentStep, furthestStep from $this->tableName where id = $this->id");
  }

  function updateSteps($currentStep, $furthestStep)
  {
    $this->rdb->insertUpdate($this->tableName, [ "currentStep" => $currentStep, "furthestStep" => $furthestStep ], [ "id" => $this->id ]);
  }
}
  
//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
