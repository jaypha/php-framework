<?php
//----------------------------------------------------------------------------
// An interface to the database for entities
//----------------------------------------------------------------------------
// Entity = A thing of interest, about which data is to be held, in a
// database accessed via Jaypha/MySQLiExt.
//----------------------------------------------------------------------------

namespace PHS;

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

    if (count($updates))
      $this->_updates = \array_merge($this->_updates, $updates);
  }

  //---------------------------------------------

  function save(array $updates = null)
  {
    assert(
      (function($u, $d){
        if ($u === null) return true;
        foreach ($u as $i => $v)
          if (!array_key_exists($i, $d))
            return false;
        return true;
      })($updates, $this->_data),
      "Trying to pass an invalid data field"
    );
        
    if ($updates !== null)
      $this->_updates = \array_merge($this->_updates, $updates);
    if (count($this->_updates))
    {
      $this->_data = \array_merge($this->_data, $this->_updates);
      $this->_save($this->_updates);
      $this->_updates = [];
    }
  }

  function flush() // deprecated
  {
    \warn("flush is deprecated");
    $this->save();
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
    global $rdb;
    switch ($p)
    {
      case "id":
        return $this->_id;
      case "rawData":
        return $this->_data;
      default:
        if (substr($p, -3) == "Orig")
        {
          $p = substr($p, 0, -4);
          return $this->data[$p];
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
// Copyright (C) 2017 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
