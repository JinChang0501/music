<?php
session_start();

if (isset($_SESSION['admin'])) {
  include __DIR__ . '/list-admin-members.php';
} else {
  include __DIR__ . '/list-no-admin-members.php';
}
