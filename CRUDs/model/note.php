<?php

class Note
{
  static protected $database;
  private $id;
  private $noteTitle;
  private $noteBody;

  /********** Active Record Design Patteren
  ************************************************************/
  static public function setDatabase($database){
    self::$database = $database;
  }

  static private function instantiate($row){
    $note = new self;
    $note->setID($row['id']);
    $note->setNoteTitle($row['noteTitle']);
    $note->setNoteBody($row['noteBody']);
    return $note;
  }

  static public function find_by_sql($sql)  {
    $result = self::$database->query($sql);
    if(!$result){
       exit("Database Query failed...");
    }

    // results into objects
    $object_array = [];
    while($row = $result->fetch_assoc()){
      $object_array[] =  self::instantiate($row);
    }
    $result->free();
    return $object_array;
  }

  static public function find_all(){
    $sql = "SELECT * FROM notes";
    return self::find_by_sql($sql);
  }

  static public function find_by_id($id){
    $sql = "SELECT * FROM notes WHERE id='". self::$database->escape_string($id)."'";
    $notes_array = self::find_by_sql($sql);
    $note = array_shift($notes_array);
    return $note;
  }

  public function create()
  {
      $sql = "INSERT INTO notes (noteTitle,noteBody) VALUES (";
      $sql .= "'". self::$database->escape_string($this->getNoteTitle()) . "',";
      $sql .= "'".  self::$database->escape_string($this->getNoteBody()) . "')";
      return self::$database->query($sql);
  }
  public function update()
  {
    $sql = "UPDATE notes SET ";
    $sql .= "noteTitle='". self::$database->escape_string($this->getNoteTitle()) ."',";
    $sql .= "noteBody='". self::$database->escape_string($this->getNoteBody()) ."' ";
    $sql .= "WHERE id='". self::$database->escape_string($this->getId()) ."' LIMIT 1";
    return self::$database->query($sql);
  }

  public function delete()
  {
    $sql = "DELETE FROM notes WHERE id='". self::$database->escape_string($this->getId()) ."' LIMIT 1";
    return self::$database->query($sql);
  }

  /********** END OF--- Active Record Design Patteren
  ************************************************************/



  public function __construct(){
  }


  public function getNoteTitle(){
    return $this->noteTitle;
  }
  public function getNoteBody(){
    return $this->noteBody;
  }
  public function getId(){
    return $this->id;
  }
  public function setID($id){
    $this->id = $id;
  }
  public function setNoteTitle($noteTitle){
    $this->noteTitle = $noteTitle;
  }
  public function setNoteBody($noteBody){
    $this->noteBody = $noteBody;
  }

}


?>
