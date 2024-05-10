<?php
session_start();

if (isset($_SESSION['admin'])) {
  include __DIR__ . '/../activities/list-activ-admin.php';
} else {
  include __DIR__ . '/../activities/list-activ-no-admin.php';
}