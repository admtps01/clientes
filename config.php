<?php
class Database{

  private $db_host = 'b5dr5eza7ubosv3x9ydq-mysql.services.clever-cloud.com';
  private $db_name = 'b5dr5eza7ubosv3x9ydq';
  private $db_username = 'uuqqcv5rsriwazye';
  private $db_password = 'KXTf4EJRJ1ERqDR2WscO';

  public function dbConnection() {
    try {
      $conn = new PDO('mysql:host='.$this->db_host.';dbname='. $this->db_name,$this->db_username,$this->db_password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    }
    catch(PDOException $e) {
      echo "Connection error ".$e->getMessage();
      exit;
    }
  }
}
?>
