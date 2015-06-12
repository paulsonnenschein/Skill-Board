<?php

namespace lib;

use PDO;
use lib\dbObject;
use lib\Requirement;
use lib\Developer;

class Project extends dbObject {

  static protected $table = "Project";
  static protected $primaryKeys = [
    'id' => 'id'
  ];
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
    parent::__construct( $db, ['id'=>$id] );
    $this->set("creationDate",date('Y-m-d'));
  }

  public function getRequirements(){
    return Requirement::findAll($this->db,[
      'project' => $this
    ]);
  }

  public function getDevelopers(Array $search=array()){
    return Developer::findAll(
      $this->db,
      array_merge(
        [ 'project' => $this ],
        $search
      )
    );
  }

}

?>