<?php

namespace lib;

use PDO;

class Project {

  private $datas;
  private $db;
  private $id;
  static private $fields = array(
    "name" => array(
      "db_key" => "name"
    ),
    "owner" => array(
      "db_key" => "Owner_Id"
    ),
    "description" => array(
      "db_key" => "description"
    ),
    "creationDate" => array(
      "db_key" => "creationDate"
    ),
    "finishedDate" => array(
      "db_key" => "finishedDate"
    )
  );

  function __construct(PDO $db,$id=null){
    $this->init();
    $this->db = $db;
    $this->id = $id;
    if($id!==null)
      $this->load();
  }

  private function init(){
    $this->datas = array();
    $this->set("creationDate",date('Y-m-d'));
  }

  private function load(){
    $sth = $this->db->prepare(
      'SELECT * FROM Project WHERE id = :id',
      array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
    );
    $sth->execute(array(
      ':id' => $this->id
    ));
    $this->datas = $sth->fetch(PDO::FETCH_ASSOC);
  }

  static public function findAll($db){
    return self::resultListToProjectList(
      $db,
      $db->query('SELECT * FROM Project')->fetchAll(PDO::FETCH_ASSOC)
    );
  }

  static public function findAllByOwner($db,$uid){
    $sth = $db->prepare(
      'SELECT * FROM Project WHERE Owner_Id = :uid',
      array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
    );
    $sth->execute(array(
      ':uid' => $uid
    ));
    return self::resultListToProjectList(
      $db,
      $sth->fetchAll(PDO::FETCH_ASSOC)
    );
  }

  static private function resultListToProjectList($db,$list){
    $result = array();
    foreach($list as $entry)
      $result[] = self::entryToProject($db,$entry);
    return $result;
  }

  static private function entryToProject($db,$entry){
    $p = new Project($db);
    $p->datas = $entry;
    $p->id = $entry['id'];
    return $p;
  }

  public function save(){
    if(!$this->id){
      $sql_keys = '';
      $sql_values = '';
      $values = array();
      foreach($this->datas as $key => $value){
        $values[':'.$key] = $value;
        $sql_keys .= ($sql_keys?',':'').' `'.$key.'`';
        $sql_values .= ($sql_values?',':'').' :'.$key;
      }
      $sql  = "INSERT INTO Project ($sql_keys ) VALUES ($sql_values )";
      $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute($values);
    } else {
      $sql_set = '';
      $values = array(':id'=>$this->id);
      foreach(self::$fields as $value){
        $key = $value['db_key'];
        $val = isset($this->datas[$key])?$this->datas[$key]:null;
        $values[':'.$key] = $val;
        $sql_set .= ($sql_set?',':'')." $key = :$key";
      }
      $sql = "UPDATE Project SET $sql_set WHERE id = :id";
      $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute($values);
    }
  }

  public function get($name){
    if(!isset(self::$fields[$name]))
      throw new Exception("A Project doesn't contain an $name\n");
    $field = self::$fields[$name];
    return @$this->datas[$field['db_key']];
  }
  
  public function set($name,$value){
    if(!isset(self::$fields[$name]))
      throw new Exception("A Project doesn't contain an $name\n");
    $field = self::$fields[$name];
    $this->datas[$field['db_key']] = $value;
  }
  
}

?>