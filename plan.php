<?php

namespace MyPlan;

class Plan {
  private $pdo;

  public function __construct() {
    try {
      $this->pdo = new \PDO(DSN,DATABASE_USERNAME,DATABASE_PASSWORD);
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch(\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  public function allPlan() {
    $sql = 'SELECT title FROM todos';
    $plans = $this->pdo->query($sql);
    return $plans;
  }
}