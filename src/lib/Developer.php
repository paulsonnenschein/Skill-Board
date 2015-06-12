<?php

namespace lib;

use PDO;
use lib\dbObject;

class Developer extends dbObject {

  static protected $table = "developer";
  static protected $primaryKeys = [
    'project' => 'Project_id',
    'user' => 'User_id'
  ];
  static protected $fields = [];

  function __construct(PDO $db,$projectId=null,$userId=null){
    parent::__construct( $db, [
      'Project_id' => $projectId,
      'User_id' => $userId
    ] );
  }

  public function getUser(){
    $uid = $this->getId('user');
    if(!$uid)
      return null;
    return new User($this->db,$uid);
  }

  public function setUser($user){
    $this->setId('user',$user->getId());
  }

  public function getProject(){
    $pid = $this->getId('project');
    if(!$pid)
      return null;
    return new User($this->db,$pid);
  }

  public function setProject($p){
    $this->setId('project',$p->getId());
  }

}

?>