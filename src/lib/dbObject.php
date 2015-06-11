<?php

namespace lib;

use PDO;

class dbObject {

  private $datas;
  private $id;

  protected $db;
  protected $idCheckSQL;

  function __construct(PDO $db,Array $id=array()){
    $this->init();
    $this->db = $db;
    $this->id = $id;
    if($this->isPrimaryKeyComplete())
      $this->load();
  }

  private function init(){
    $this->datas = [];
    $this->set("creationDate",date('Y-m-d'));
    $this->idCheckSQL = $this->genIdCheckSQL();
  }

  private function genIdCheckSQL(){
    $sql = '';
    foreach(static::$primaryKeys as $val)
      $sql .= ($sql?' AND':'')." $val = :$val";
    return $sql;
  }

  protected function genIdCheckSQLAddParams($arr=[]){
    foreach(static::$primaryKeys as $val)
      $arr[":$val"] = $this->id[$val];
    return $arr;
  }

  protected function load(){
    $sth = $this->db->prepare(
      'SELECT * FROM '.static::$table.' WHERE '.$this->idCheckSQL,
      [ PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ]
    );
    $sth->execute($this->genIdCheckSQLAddParams());
    $this->datas = $sth->fetch(PDO::FETCH_ASSOC);
  }

  static public function findAll($db){
    return self::resultListToDBOList(
      $db,
      $db->query('SELECT * FROM '.static::$table)->fetchAll(PDO::FETCH_ASSOC)
    );
  }

  static protected function resultListToDBOList($db,$list){
    $result = [];
    foreach($list as $entry)
      $result[] = self::entryToDBO($db,$entry);
    return $result;
  }

  static protected function entryToDBO($db,$entry){
    $p = new Project($db);
    $p->datas = $entry;
    $p->id = $entry['id'];
    return $p;
  }

  public function save(){
    if(!$this->id){
      $sql_keys = '';
      $sql_values = '';
      $values = [];
      foreach($this->datas as $key => $value){
        $values[':'.$key] = $value;
        $sql_keys .= ($sql_keys?',':'').' `'.$key.'`';
        $sql_values .= ($sql_values?',':'').' :'.$key;
      }
      $sql  = "INSERT INTO ".static::$table." ($sql_keys ) VALUES ($sql_values )";
      $sth = $this->db->prepare($sql, [ PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ]);
      $sth->execute($values);
    } else {
      $sql_set = '';
      $values = $this->genIdCheckSQLAddParams();
      foreach(static::$fields as $value){
        $key = $value['db_key'];
        $val = isset($this->datas[$key])?$this->datas[$key]:null;
        $values[':'.$key] = $val;
        $sql_set .= ($sql_set?',':'')." $key = :$key";
      }
      $sql = "UPDATE ".static::$table." SET $sql_set WHERE ".$this->idCheckSQL;
      $sth = $this->db->prepare($sql, [ PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ]);
      $sth->execute($values);
    }
  }

  public function get($name){
    if(!isset(static::$fields[$name]))
      throw new Exception("A ".static::$table." doesn't contain an $name\n");
    $field = static::$fields[$name];
    return @$this->datas[$field['db_key']];
  }
  
  public function set($name,$value){
    if(!isset(static::$fields[$name]))
      throw new Exception("A ".static::$table." doesn't contain an $name\n");
    $field = static::$fields[$name];
    $this->datas[$field['db_key']] = $value;
  }
  
  public function getId($name=null){
    if($name)
      $name = static::$primaryKeys[name];
    else
      $name = end(static::$primaryKeys);
    return @$this->id[$name];
  }

  public function setId($name=null,$value=null){
    if($name)
      $name = static::$primaryKeys[name];
    else
      $name = end(static::$primaryKeys);
    $this->id[$name] = $value;
  }

  public function isPrimaryKeyComplete(){
    foreach(static::$primaryKeys as $key)
      if(!isset($this->id[$key])&&$this->id[$key])
        return false;
    return true;
  }

}

?>