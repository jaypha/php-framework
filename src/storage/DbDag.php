<?php
//----------------------------------------------------------------------------
// This defines a database stored directed acyclic grpah
//----------------------------------------------------------------------------

namespace Jaypha;

class DbDag
{
  protected $name;

  //-----------------------------------------------

  function __construct($name)
  {
    $this->name = $name;
  }

  //-----------------------------------------------

  function getNodes($parentId = null)
  {
    global $rdb;

    if ($parentId == null)
      return $rdb->queryData("select * from $this->nodeTable order by listOrder asc");
    else
    {
      $query = "select * from $this->linkTable
                left join $this->nodeTable
                on (childId = id)
                where parentId=$parentId
                order by $this->linkTable.listOrder asc";

      return $rdb->queryData($query);
    }
  }

  //-----------------------------------------------

  function getParents($nodeId)
  {
    global $rdb;

    $query = "select * from $this->linkTable
              left join $this->nodeTable
              on (parentId = id)
              where childId=$nodeId
              order by $this->linkTable.listOrder asc";

    return $rdb->queryData($query);
  }

  //-----------------------------------------------

  function getRoots() {
    global $rdb;
    $childNodes = $rdb->queryColumn("select distinct childId from $this->linkTable");
    if (count($childNodes) == 0)
      return $this->getNodes();
    return $rdb->queryData("select * from $this->nodeTable where not id in (".$rdb->quote($childNodes).")");
  }

  //-----------------------------------------------

  function addLink($parentId, $childId)
  {
    global $rdb;
    $rdb->insert($this->linkTable,[ "parentId" => $parentId, "childId" => $childId]);
  }

  //-----------------------------------------------

  function removeLink($parentId, $childId)
  {
    global $rdb;
    $rdb->delete($this->linkTable,[ "parentId" => $parentId, "childId" => $childId]);
  }

  //-----------------------------------------------

  function addNode($nodeData)
  {
    assert(!isset($nodeData["id"]));
    global $rdb;
    return $rdb->insert($this->nodeTable,$nodeData);
  }

  //-----------------------------------------------

  function removeNode($nodeId)
  {
    global $rdb;
    $rdb->q("delete from $this->linkTable where parentId=$nodeId or childId=$nodeId");
    $rdb->delete($this->nodeTable,$nodeId);
  }

  //-----------------------------------------------

  function __get($p)
  {
    switch ($p)
    {
      case "linkTable":
        return "{$this->name}_links";
      case "nodeTable":
        return "{$this->name}_nodes";
    }
  }

  //-----------------------------------------------

  function integrityCheck()
  {
  }

  //-----------------------------------------------

  function getLinkDbDef()
  {
    return [
      "type" => "table",
      "name" => "{$this->name}_links",
      "noid" => true,
      "columns" => [
        "parentId" => FixDB::uintType(9999),
        "childId" => FixDB::uintType(),
        "listOrder" => FixDB::uintType(9999)
      ],
      "indicies" => [
        "parentId" => [],
        "childId" => []
      ]
    ];
  }

  //-----------------------------------------------

  function getNodeDbDef()
  {
    return [
      "type" => "table",
      "name" => "{$this->name}_nodes",
      "columns" => [
        "listOrder" => FixDB::uintType(9999),
      ],
      "indicies" => [
      ]
    ];
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2019 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
