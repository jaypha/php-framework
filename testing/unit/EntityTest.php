<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use PHPUnit\Framework\TestCase;

class Entity extends \Jaypha\Entity
{
  const tableName = "___TestTable___";

  function tableSave() { return self::tableName; }
  function tableRead() { return self::tableName; }
  function tableFields() { return []; }

  function __get(string $p)
  {
    switch ($p)
    {
      case "_id":
      case "_data":
      case "_updates":
        return $this->$p;
      default:
        return parent::__get($p);
    }
  }
}

class EntityTest extends TestCase
{
  const tableName = "___TestTable___";
  const tableDef = "CREATE TABLE `".self::tableName."` (`id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(255) NOT NULL DEFAULT '',  `age` int(11) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4;";

  public static function setUpBeforeClass()
  {
    assert(isset($GLOBALS["rdb"]));
    global $rdb;
    $rdb->query("drop table  if exists `".self::tableName."`");
    $rdb->query(self::tableDef);
  }

  function setUp()
  {
    global $rdb;
    $rdb->insert(self::tableName, [ 'name', 'age' ], [
      ['mandy',15],
      ['andy',16],
      ['randy',17],
      ['john',27],
      ["xy", 44],
      ["z", 0]
    ]);
  }

  function testCreate()
  {
    global $rdb;

    $entity = new Entity($rdb->get(self::tableName, 3));
    $this->assertEquals($entity->_id, 3);
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "randy", "age" => 17]);
    $this->assertEquals($entity->_updates, []);
    $this->assertEquals($entity->rawData, ["id"=>3, "name" => "randy", "age" => 17]);
    $this->assertEquals($entity->id, 3);
    $this->assertEquals($entity->name, "randy");
    $this->assertEquals($entity->age, 17);
  }

  function testUpdate()
  {
    global $rdb;

    $entity = new Entity($rdb->get(self::tableName, 3));
    $this->assertEquals($entity->_id, 3);
    $entity->name = "john";
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "randy", "age" => 17]);
    $this->assertEquals($entity->_updates, [ "name" => "john"]);
    $this->assertEquals($entity->name, "john");
    $entity->update([ "age" => 20 ]);
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "randy", "age" => 17]);
    $this->assertEquals($entity->_updates, [ "name" => "john", "age" => 20]);
    $this->assertEquals($entity->name, "john");
    $this->assertEquals($entity->age, 20);
  }

  function testSave()
  {
    global $rdb;

    $entity = new Entity($rdb->get(self::tableName, 3));
    $entity->name = "john";
    $entity->save();
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "john", "age" => 17]);
    $this->assertEquals($entity->_updates, []);
    $this->assertEquals($rdb->get(self::tableName, 3), ["id"=>3, "name" => "john", "age" => 17]);
    $entity->save( [ "age" => 20 ] );
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "john", "age" => 20]);
    $this->assertEquals($rdb->get(self::tableName, 3), ["id"=>3, "name" => "john", "age" => 20]);

    $entity->age = 30;
    $entity->save( [ "name" => "bill" ] );
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "bill", "age" => 30]);
    $this->assertEquals($rdb->get(self::tableName, 3), ["id"=>3, "name" => "bill", "age" => 30]);
  }

  function testRefresh()
  {
    global $rdb;

    $entity = new Entity($rdb->get(self::tableName, 3));
    $this->assertEquals($entity->_id, 3);
    $entity->name = "john";
    $this->assertEquals($entity->name, "john");
    $entity->refresh();
    $this->assertEquals($entity->_data, ["id"=>3, "name" => "randy", "age" => 17]);
    $this->assertEquals($entity->_updates, []);
    $this->assertEquals($entity->name, "randy");
  }

  function tearDown()
  {
    global $rdb;
    $rdb->query("truncate ".self::tableName);
  }

  public static function tearDownAfterClass()
  {
    global $rdb;
    $rdb->query("drop table if exists `".self::tableName."`");
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2006-18 Prima Health Solutions Pty Ltd. All rights reserved.
// Author: Jason den Dulk
//
