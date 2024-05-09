<?php
session_start();

if (isset($_SESSION['admin'])) {
  include __DIR__ . '/list-activ-admin.php';
} else {
  include __DIR__ . '/list-activ-no-admin.php';
}