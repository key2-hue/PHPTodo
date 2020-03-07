<?php

require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/plan.php');

session_start();

$plan = new \MyPlan\Plan();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $s = $plan->send();
    header('Content-Type: application/json');
    echo json_encode($s);
    exit;
  } catch(Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . '500 Internal Server Error', true, 500);
    echo $e->getMessage();
    exit;
  }
}