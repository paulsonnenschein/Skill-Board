<?php

namespace lib;

use PDO;
use lib\dbObject;

class Project extends dbObject {

  static protected $table = "Project";
  static protected $primaryKeys = ['id'];
  static protected $fields = [
    "name" => [
      "db_key" => "name"
    ],
    "owner" => [
      "db_key" => "Owner_Id"
    ],
    "description" => [
      "db_key" => "description"
    ],
    "creationDate" => [
      "db_key" => "creationDate"
    ],
    "finishedDate" => [
      "db_key" => "finishedDate"
    ]
  ];

  function __construct(PDO $db,$id=null){
    parent::__construct( $db, $id===null ? null : ['id'=>$id] );
  }

  static public function findAllByOwner($db,$uid){
    $sth = $db->prepare(
      'SELECT * FROM Project WHERE Owner_Id = :uid',
      array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
    );
    $sth->execute([ ':uid' => $uid ]);
    return self::resultListToDBOList(
      $db,
      $sth->fetchAll(PDO::FETCH_ASSOC)
    );
  }

}

?>