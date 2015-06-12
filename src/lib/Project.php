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

  public function getMatchingUsers($limit=10){
    $sql = "
SELECT u.*,d.* FROM User AS u
INNER JOIN skills AS s
  ON s.User_id = u.id
INNER JOIN requirements AS r
  ON r.ProgrammingLanguages_id = s.ProgrammingLanguages_id
  AND r.Project_id = :project
LEFT JOIN developer as d
  ON d.User_id = s.User_id
  AND d.Project_id = r.Project_id
WHERE
     d.statusProject = 'UNDECIDED'
  OR d.statusProject IS NULL
GROUP BY
  u.id
ORDER BY
  COUNT(r.ProgrammingLanguages_id) DESC
LIMIT $limit
";
    $sth = $this->db->prepare($sql);
    $sth->execute([
      ':project' => $this->getId()
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}

?>