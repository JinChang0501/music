<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['admin'])) {
  //待串聯
  // header('Location: login.php');
  header('Location: index_R3.php');
  exit;
}