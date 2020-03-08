<?php

require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/plan.php');

session_start();

$planAll = new \MyPlan\Plan();
$plan = $planAll->allPlan();

$pdo = $planAll->pdo;
$done = $planAll->done();
$undone = $planAll->undone();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Todoアプリ</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
 <div id="plans">
 <div class="planList">
  <h1>予定一覧</h1>
  <button>全て消す</button>
 </div>
  <ul id="planAll">
    <div class="todoNow">
      終わったタスク
      <?php foreach ($done as $p): ?>
        <li id="<?= h($p->id);?>" data-id="<?= h($p->id); ?>" class="all">
          <input type="checkbox" class="update" <?php if ($p->state === '1') {echo 'checked';}?>>
          <p class="title <?php if ($p->state === '1') {echo 'finished';}?>"><?= h($p->title); ?></p>
          <div class="cross">x</div>
        </li>
      <?php endforeach; ?>
    </div>
    <div class="todoNow">
      終わっていないタスク
      <?php foreach ($undone as $p): ?>
        <li id="<?= h($p->id);?>" data-id="<?= h($p->id); ?>" class="all">
          <input type="checkbox" class="update" <?php if ($p->state === '1') {echo 'checked';}?>>
          <p class="title <?php if ($p->state === '1') {echo 'finished';}?>"><?= h($p->title); ?></p>
          <div class="cross">x</div>
        </li>
      <?php endforeach; ?>
    </div>
    <li id="addingPlan" data-id="" class="all">
      <input type="checkbox" class="update">
      <p class="title"></p>
      <div class="cross">x</div>
    <li>
    <p class="errorSentence"></p>
  </ul>
  <form action="" id="form">
    <input type="text" placeholder="予定を入力してください" id="text">
    <input type="submit" value="送信する">
  </form>
  <input type="hidden" id="token" value="<?= h($_SESSION['token']);?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="index.js"></script>
 </div>
</body>
</html>