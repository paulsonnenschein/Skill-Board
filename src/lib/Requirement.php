<?php

namespace lib;

use PDO;
use lib\dbObject;

class Requirement extends dbObject {

  static protected $table = "requirements";
  static protected $primaryKeys = [
    'project' => 'Project_id',
    'programmingLanguage' => 'ProgrammingLanguages_id'
  ];
  static protected $fields = [];

  function __construct(PDO $db,$projectId=null,$programmingLanguageId==null){
    parent::__construct( $db, [
      'Project_id' => $projectId,
      'ProgrammingLanguages_id' => $programmingLanguageId
    ] );
  }

  public function getProgrammingLanguage(){
    $plid = $this->getId('programmingLanguage');
    if(!$plid)
      return null;
    return new ProgrammingLanguage($this->db,$plid);
  }

  public function setProgrammingLanguage($pl){
    $this->setId('programmingLanguage',$pl->getId());
  }

  public function getProject(){
    $pid = $this->getId('project');
    if(!$pid)
      return null;
    return new ProgrammingLanguage($this->db,$pid);
  }

  public function setProject($p){
    $this->setId('project',$p->getId());
  }

}

?>