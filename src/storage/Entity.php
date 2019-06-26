<?php
//----------------------------------------------------------------------------
// An interface to the database for entities
//----------------------------------------------------------------------------
// Entity = A thing of interest, about which data is to be held, in a
// database accessed via Jaypha/MySQLiExt.
//----------------------------------------------------------------------------

namespace Jaypha;

abstract class Entity
{
  abstract function tableSave();
  abstract function tableRead();
  abstract function tableFields();


  //---------------------------------------------

  function __construct(array $data)
  {
    assert(isset($GLOBALS["rdb"]));
    $this->_id = $data["id"];
    $this->_data = $data;
  }

  //---------------------------------------------

  // Extra functions here
  
  //---------------------------------------------

  function update(array $updates)
  {
    assert(
      (function($u, $d){
        foreach ($u as $i => $v)
          if (!array_key_exists($i, $d))
            return false;
        return true;
      })($updates, $this->_data),
      "Trying to pass an invalid data field"
    );

    unset($updates["id"]);
    if (count($updates))
      $this->_updates = \array_merge($this->_updates, $updates);
  }

  //---------------------------------------------

  function save(array $updates = null)
  {
    if ($updates !== null)
      $this->update($updates);
    if (count($this->_updates))
    {
      $this->_data = \array_merge($this->_data, $this->_updates);
      $this->_save($this->_updates);
      $this->_updates = [];
    }
  }

  //---------------------------------------------

  function refresh()
  {
    global $rdb;
    $this->_data = $rdb->get($this->tableRead(), $this->_id);
    $this->_updates = [];
  }

  //---------------------------------------------

  function __get(string $p)
  {
    switch ($p)
    {
      case "id":
        return $this->_id;
      case "rawData":
        return $this->_data;
      default:
        if (substr($p, -4) == "Orig")
        {
          $p = substr($p, 0, -4);
          return $this->_data[$p];
        }
        else if (substr($p, -3) == "Raw")
          $p = substr($p, 0, -3);
        return $this->_data($p);
    }
  }

  //---------------------------------------------

  function __set(string $p, $v)
  {
    if (!array_key_exists($p, $this->_data))
      throw new \Exception("Property '$p' is not defined for ".get_class());

    $this->_updates[$p] = $v;
  }

  //---------------------------------------------

  protected function _data($p)
  {
    if (!array_key_exists($p, $this->_data))
      throw new \Exception("Property '$p' is not defined for ".get_class());

    if (array_key_exists($p, $this->_updates))
      return $this->_updates[$p];
    else
      return $this->_data[$p];
  }

  protected function _save($data)
  {
    global $rdb;
    if (count($data))
     $rdb->set($this->tableSave(), $data, $this->_id);
  }

  //---------------------------------------------

  function delete()
  {
    $GLOBALS["rdb"]->remove($this->tableSave(), $this->_id);
  }

  //---------------------------------------------

  protected $_id;
  protected $_data;
  protected $_updates = [];
}

//----------------------------------------------------------------------------
// Copyright (C) 2018 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
