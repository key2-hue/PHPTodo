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
    $this->checkToken();
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
      case 'deleteAll':
        return $this->deleteAll();
    }
  }

  private function create() {
    if(!isset($_POST['todo']) || $_POST['todo'] === '') {
      throw new \Exception('IDがセットされていません');
    }

    $sql = "insert into todos (title, state) values (:title, :state)";
    $create = $this->pdo->prepare($sql);
    $create->bindValue(':title', $_POST['todo'], \PDO::PARAM_STR);
    $create->bindValue(':state', 0, \PDO::PARAM_INT);
    $create->execute();

    return [
      'id' => $this->pdo->lastInsertId()
    ];
  }

  private function delete() {
    if(!isset($_POST['id'])) {
      throw new \Exception('IDがセットされていません');
    }
    $sql = sprintf("delete from todos where id = %d", $_POST['id']);
    $delete = $this->pdo->prepare($sql);
    $delete->execute();

    return[];
  }

  private function deleteAll() {
    $sql = "truncate table todos";
    $delete = $this->pdo->prepare($sql);
    $delete->execute();

    return $sql;
  }

  private function update() {
    if(!isset($_POST['id'])) {
      throw new \Exception ('IDがセットされていません');
    }

    $this->pdo->beginTransaction();

    $sql = sprintf("update todos set state = (state + 1) %% 2 WHERE id = %d", $_POST['id']);
    $good = $this->pdo->prepare($sql);
    $good->execute();

    $sql = sprintf("select state from todos where id = %d", $_POST['id']);
    $good = $this->pdo->query($sql);
    $state = $good->fetchColumn();

    $this->pdo->commit();

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