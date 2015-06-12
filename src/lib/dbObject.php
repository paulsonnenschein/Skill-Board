<?php

namespace lib;

use PDO;

class dbObject {

  private $datas;
  private $id;
  private $saved;

  protected $db;
  protected $idCheckSQL;

  function __construct(PDO $db,Array $id=[]){
    $this->init();
    $this->db = $db;
    $this->id = $id;
    $this->saved = false;
    if($this->isPrimaryKeyComplete())
      $this->load();
  }

  private function init(){
    $this->datas = [];
    $this->idCheckSQL = $this->genIdCheckSQL();
  }

  private function genIdCheckSQL(){
    $sql = '';
    foreach(static::$primaryKeys as $val)
      $sql .= ($sql?' AND':'')." $val = :$val";
    return $sql;
  }

  protected function genIdCheckSQLAddParams(Array $arr=[]){
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
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if($result){
      $this->datas = $result;
      $this->saved = true;
    }
  }

  static public function findAll(PDO $db,Array $search=[]){
    $sql_search = '';
    $values = [];
    foreach($search as $name => $value){
      $key = null;
      if(isset(static::$primaryKeys[$name])){
        $key = static::$primaryKeys[$name];
      }else if(isset(static::$fields[$name])){
        $key = static::$fields[$name]['db_key'];
      }else continue;
      $values[':'.$key] = ($value instanceof dbObject) ? $value->getId() : $value;
      $sql_search .= ($sql_search?' AND':' WHERE')." $key = :$key";
    }
    $sql = 'SELECT * FROM '.static::$table.$sql_search;
    $sth = $db->prepare($sql);
    $sth->execute($values);
    return self::resultListToDBOList( $db, $sth->fetchAll(PDO::FETCH_ASSOC) );
  }

  static protected function resultListToDBOList(PDO $db,Array $list){
    $result = [];
    foreach($list as $entry)
      $result[] = self::entryToDBO($db,$entry);
    return $result;
  }

  static protected function entryToDBO(PDO $db,Array $entry){
    $class = get_called_class();
    $p = new $class($db);
    $p->datas = $entry;
    foreach(static::$primaryKeys as $key)
      $p->id[$key] = $entry[$key];
    return $p;
  }

  public function save(){
    if(!$this->saved){
      $sql_keys = '';
      $sql_values = '';
      $values = $this->genIdCheckSQLAddParams();
      foreach($this->datas as $key => $value){
        $values[':'.$key] = ($value instanceof dbObject) ? $value->getId() : $value;
        $sql_keys .= ($sql_keys?',':'').' `'.$key.'`';
        $sql_values .= ($sql_values?',':'').' :'.$key;
      }
      foreach(static::$primaryKeys as $key){
        if( !isset($this->id[$key]) || !$this->id[$key] )
          continue;
        $value = $this->id[$key];
        $values[':'.$key] = ($value instanceof dbObject) ? $value->getId() : $value;
        $sql_keys .= ($sql_keys?',':'').' `'.$key.'`';
        $sql_values .= ($sql_values?',':'').' :'.$key;
      }
      $sql  = "INSERT INTO ".static::$table." ($sql_keys ) VALUES ($sql_values )";
      $sth = $this->db->prepare($sql, [ PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ]);
      $this->id = $sth->execute($values);
    } else {
      $sql_set = '';
      $values = $this->genIdCheckSQLAddParams();
      foreach(static::$fields as $value){
        $key = $value['db_key'];
        $val = isset($this->datas[$key])?$this->datas[$key]:null;
        $values[':'.$key] = $val;
        $sql_set .= ($sql_set?',':' SET')." $key = :$key";
      }
      if($sql_set){
        $sql = "UPDATE ".static::$table." $sql_set WHERE ".$this->idCheckSQL;
        $sth = $this->db->prepare($sql, [ PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ]);
        $sth->execute($values);
      }
    }
    $this->saved = true;
  }

  public function get($name){
    if(!isset(static::$fields[$name]))
      throw new \Exception("A ".static::$table." doesn't contain a $name\n");
    $field = static::$fields[$name];
    return @$this->datas[$field['db_key']];
  }

  public function set($name,$value=null){
    if(!isset(static::$fields[$name]))
      throw new \Exception("A ".static::$table." doesn't contain a $name\n");
    $field = static::$fields[$name];
    $this->datas[$field['db_key']] = $value;
  }

  public function getId($name=null){
    if($name)
      $name = static::$primaryKeys[$name];
    else
      $name = end(static::$primaryKeys);
    return @$this->id[$name];
  }

  public function setId($name=null,$value=null){
    if($name)
      $name = static::$primaryKeys[$name];
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