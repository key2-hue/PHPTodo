<?php

require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/plan.php');

session_start();

$planAll = new \MyPlan\Plan();
$plan = $planAll->allPlan();
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
 <h1>予定一覧</h1>
  <ul id="planAll">
    <?php foreach ($plan as $p): ?>
      <li id="<?= h($p->id);?>" data-id="<?= h($p->id); ?>">
        <input type="checkbox" class="update" <?php if ($p->state === '1') {echo 'checked';}?>>
        <p class="title <?php if ($p->state === '1') {echo 'done';}?>"><?= h($p->title); ?></p>
        <div class="cross">x</div>
      </li>
    <?php endforeach; ?>
  </ul>
  <form action="">
    <input type="text" placeholder="予定を入力してください">
    <input type="hidden" id="token" value="<?= h($_SESSION['token']);?>">
    <input type="submit" value="送信する">
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="index.js"></script>
 </div>
</body>
</html>