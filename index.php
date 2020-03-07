<?php

require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/plan.php');

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
  <ul>
    <?php foreach ($plan as $p): ?>
      <li>
        <input type="checkbox" <?php if ($p->state === '1') {echo 'checked';}?>>
        <p class="<?php if ($p->state === '1') {echo 'done';}?>"><?= h($p->title); ?></p>
        <div class="cross">x</div>
      </li>
    <?php endforeach; ?>
  </ul>
  <form action="">
    <input type="text" placeholder="予定を入力してください">
    <input type="submit" value="送信する">
  </form>
 </div>
</body>
</html>