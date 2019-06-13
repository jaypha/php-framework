<?php
//----------------------------------------------------------------------------
//
//----------------------------------------------------------------------------

use PHPUnit\Framework\TestCase;
use Jaypha\DbDag;

class DbDagTest extends TestCase
{
  const tableName = "___DbDag";

  public static function setUpBeforeClass()
  {
    assert(isset($GLOBALS["rdb"]));
    global $rdb;

    $dbDag = new DbDag(self::tableName);

    $rdb->query("drop table  if exists `$dbDag->linkTable`");
    $rdb->query("drop table  if exists `$dbDag->nodeTable`");

    $fixdb = new \Jaypha\FixDB($rdb);

    $fixdb->add($dbDag->getLinkDbDef());
    $fixdb->add($dbDag->getNodeDbDef());
    $fixdb->execute();
  }

  public function testRoots()
  {
    global $rdb;
    $dbDag = new DbDag(self::tableName);

    $id1 = $dbDag->addNode(["listOrder" => 1]);
    $id2 = $dbDag->addNode(["listOrder" => 2]);
    $nodes = $dbDag->getRoots();
    $this->assertInternalType("array", $nodes);
    $this->assertCount(2, $nodes);
    $this->assertEquals($id1, $nodes[0]["id"]);
    $this->assertEquals($id2, $nodes[1]["id"]);

    $dbDag->addLink($id1,$id2);
    $nodes = $dbDag->getRoots();
    $this->assertInternalType("array", $nodes);
    $this->assertCount(1, $nodes);
    $this->assertEquals($id1, $nodes[0]["id"]);
  }

  public function testLink()
  {
    global $rdb;
    $dbDag = new DbDag(self::tableName);

    $id1 = $dbDag->addNode(["listOrder" => 1]);
    $id2 = $dbDag->addNode(["listOrder" => 2]);
    $id3 = $dbDag->addNode(["listOrder" => 3]);

    $dbDag->addLink($id1,$id2);
    $dbDag->addLink($id1,$id3);

    $nodes = $dbDag->getNodes($id1);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(2, $nodes);

    $nodes = $dbDag->getNodes($id2);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(0, $nodes);

    $nodes = $dbDag->getNodes($id3);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(0, $nodes);

    $dbDag->addLink($id2,$id3);

    $nodes = $dbDag->getNodes($id2);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(1, $nodes);

    $nodes = $dbDag->getParents($id1);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(0, $nodes);

    $nodes = $dbDag->getParents($id2);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(1, $nodes);

    $nodes = $dbDag->getParents($id3);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(2, $nodes);

    $dbDag->removeLink($id2,$id3);

    $nodes = $dbDag->getParents($id3);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(1, $nodes);

    $dbDag->removeNode($id3);
    $nodes = $dbDag->getNodes($id1);
    $this->assertInternalType("array", $nodes);
    $this->assertCount(1, $nodes);
  }

  public static function tearDownAfterClass()
  {
    global $rdb;
    $dbDag = new DbDag(self::tableName);

    $rdb->query("drop table  if exists `$dbDag->linkTable`");
    $rdb->query("drop table  if exists `$dbDag->nodeTable`");
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
