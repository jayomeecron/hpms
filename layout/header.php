<?php
require_once(__DIR__ . "/../dbcon.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Global Hospital</title>

  <!-- Google Font: Source Sans Pro -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/fontawesome-free/css/all.min.css" />
  <!-- Ionicons -->
  <link
    rel="stylesheet"
    href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- Full Calendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />

  <!-- Tempusdominus Bootstrap 4 -->
  <link
    rel="stylesheet"
    href="<?= BASE_URL ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
  <!-- iCheck -->
  <link
    rel="stylesheet"
    href="<?= BASE_URL ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/jqvmap/jqvmap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/dist/css/adminlte.min.css" />
  <!-- overlayScrollbars -->
  <link
    rel="stylesheet"
    href="<?= BASE_URL ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/daterangepicker/daterangepicker.css" />
  <!-- Summernote -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/summernote/summernote-bs4.min.css" />
  <!-- Jquery for full Calendar -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Full Calendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <!-- <div
      class="preloader flex-column justify-content-center align-items-center">
      <img
        class="animation__shake"
        src="dist/img/AdminLTELogo.png"
        alt="AdminLTELogo"
        height="60"
        width="60" />
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= BASE_URL ?>/dashboard.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= BASE_URL ?>/aboutus.php" class="nav-link">About Us</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= BASE_URL ?>/contactus.php" class="nav-link">Contact Us</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <!-- <li class="nav-item">
          <form action="<?= BASE_URL . "/auth/logout.php" ?>" method="POST" class="form-inline">
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-sign-out-alt"></i> Logout
            </button>
          </form>
        </li> -->
      </ul>
    </nav>