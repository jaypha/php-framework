<?php
//----------------------------------------------------------------------------
// Used for a tag related functionality. Each tag group has its own database.
//----------------------------------------------------------------------------

namespace Jaypha;

class Tags
{
  private $tableName;

  //-----------------------------------

  function __construct(string $table)
  {
    $this->tableName = $table;
  }

  //-----------------------------------

  function getTags($refId = 0)
  {
    assert(is_int($refId) || ctype_digit($refId));
    global $rdb;

    $query = "select distinct tagName from $this->tableName";
    if ($refId)
      $query .= " where refId = $refId";
    return $rdb->queryColumn($query);
  }

  //-----------------------------------

  function hasTag($refId, string $tagName): bool
  {
    assert(is_int($refId) || ctype_digit($refId));
    global $rdb;

    return ($rdb->queryValue("select count(*) from $this->tableName where refId = $refId and tagName = ".$rdb->quote($tagName)) != "0");
  }

  //-----------------------------------

  function hasOneOfTags($refId, array $tagNames): bool
  {
    assert(is_int($refId) || ctype_digit($refId));
    global $rdb;

    if (count($tagNames))
      return ($rdb->queryValue("select count(*) from $this->tableName where refId = $refId and tagName in (".$rdb->quote($tagNames).")") != "0");
  }

  //-----------------------------------

  function getRefs($tagNames)
  {
    if (!is_array($tagNames))
      $tagNames = [ $tagNames ];
      
    global $rdb;

    if (count($tagNames))
      return $rdb->queryColumn("select distinct refId from $this->tableName where tagName in (".$rdb->quote($tagNames).")");
    else
      return [];
  }

  //-----------------------------------

  function update($refId, array $tagNames)
  {
    assert(is_int($refId) || ctype_digit($refId));
    global $rdb;

    $rdb->query("delete from $this->tableName where refId=$refId");

    if (count($tagNames))
    {
      $x = [];
      foreach ($tagNames as $tag)
        $x[] = [$refId, $tag];
      $rdb->insert($this->tableName, ["refId","tagName"],$x);
    }      
  }

  //-----------------------------------

  function add($refId, $tagName)
  {
    global $rdb;
    $rdb->replace($this->tableName, ["refid"=>$refId, "tagName"=>$tagName]);
  }

  //-----------------------------------

  function remove($refId, $tagNames)
  {
    assert(is_int($refId) || ctype_digit($refId));
    if (!is_array($tagNames))
      $tagNames = [ $tagNames ];

    global $rdb;

    if (count($tagNames))
      $rdb->delete($this->tableName, [ "refId" => $refId, "tagName" => $tagNames]);
  }

  //-----------------------------------

  static function getDbDef($name)
  {
    return [
      "type" => "table",
      "name" => $name,
      "engine" => "MyISAM",
      "noid" => true,
      "columns" => [
        "tagName" => ["type"=>"string","size"=>250,"default"=>""],
        "refId" => ["type"=>"int","unsigned"=>true,"nullable"=>false,"default"=>0],
      ],
      "indicies" => [
        "tagName" => [],
        "refId" => []
      ]
    ];
  }
}

//----------------------------------------------------------------------------
// Copyright (C) 2017 Jaypha.
// License: BSL-1.0
// Author: Jason den Dulk
//
