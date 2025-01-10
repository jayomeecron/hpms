<?php
require_once('../constants.php');
session_start();
$role = $_SESSION['role'];
session_unset();
session_destroy();
$_SESSION = array();
switch ($role) {
  case "admin";
    header("Location: " . BASE_URL . "/auth/login.php");
    exit();
  case "patient";
    header("Location: " . BASE_URL . "/auth/login.php");
    exit();
  case "doctor";
    header("Location: " . BASE_URL . "/auth/login.php");
    exit();
  default:
    return false;
}
