<?php

namespace MyPlan;

class Plan {
  private $pdo;

  public function __construct() {
    $this->token();
    try {
      $this->pdo = new \PDO(DSN,DATABASE_USERNAME,DATABASE_PASSWORD);
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch(\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  private function token() {
    if(!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  private function checkToken() {
    if(
      !isset($_SESSION['token']) ||
      !isset($_POST['token']) ||
      $_SESSION['token'] !== $_POST['token']
    ) {
      throw new \Exception('無効なトークンです');
    }
  }

  public function send() {
    if(!isset($_POST['way'])) {
      throw new \Exception('通信に失敗しました');
    }

    switch($_POST['way']) {
      case 'update':
        return $this->update();
      case 'create':
        return $this->create();
      case 'delete':
        return $this->delete();
    }
  }

  private function update() {
    if(!isset($_POST['id'])) {
      throw new \Exception ('IDがセットされていません');
    }

    $this->pdo->beginTransaction();

    $sql = sprintf("UPDATE todos SET state = (state + 1) %% 2 WHERE id = %d", $_POST['id']);
    $good = $this->pdo->prepare($sql);
    $good->execute();

    $sql = sprintf("SELECT state FROM todos where id = %d", $_POST['id']);
    $good = $this->pdo->query($sql);
    $state = $good->fetchColumn();

    return [
      'state' => $state
    ];
  }

  public function allPlan() {
    $sql = 'SELECT * FROM todos ORDER BY id asc';
    $plans = $this->pdo->query($sql);
    return $plans->fetchAll(\PDO::FETCH_OBJ);
  }
}