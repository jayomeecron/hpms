<?php
require_once(__DIR__ . "/../dbcon.php");

// Set current page for active menu highlighting
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="dashboard.php" class="brand-link">
    <img
      src="<?= BASE_URL ?>/dist/img/logo2.png"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: 0.8" />
    <span class="brand-text font-weight-light">Global Hospital</span>
  </a>

  <!-- Sidebar -->
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img
        src="<?= BASE_URL ?>/dist/img/user2-160x160.jpg"
        class="img-circle elevation-2"
        alt="User Image" />
    </div>
    <div class="info">
      <a href="#" class="d-block" style="color: white;"><?php echo $_SESSION['username']; ?></a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Common Menu (Visible to All Roles) -->
      <li class="nav-item">
        <a href="<?= BASE_URL ?>/dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Menu for Patient -->
      <?php if ($_SESSION['role'] == 'patient') { ?>
        <li class="nav-item">
          <a href="<?= PATIENT_URL ?>/appointment.php" class="nav-link <?php echo ($currentPage == 'appointment.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>Book Appointment</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= PATIENT_URL ?>/appointment_history.php" class="nav-link <?php echo ($currentPage == 'appointment_history.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-history"></i>
            <p>Appointment History</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= PATIENT_URL ?>/pat_prescription.php" class="nav-link <?php echo ($currentPage == 'pat_prescription.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-file-medical"></i>
            <p>Prescription</p>
          </a>
        </li>
      <?php } ?>

      <!-- Menu for Doctor -->
      <?php if ($_SESSION['role'] == 'doctor') { ?>
        <li class="nav-item">
          <a href="<?= DOCTOR_URL ?>/doc_appointment.php" class="nav-link <?php echo ($currentPage == 'doc_appointment.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-calendar-day"></i>
            <p>Appointments</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= DOCTOR_URL ?>/doc_prescription.php" class="nav-link <?php echo ($currentPage == 'doc_prescription.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-list"></i>
            <p>Prescription List</p>
          </a>
        </li>
      <?php } ?>

      <!-- Menu for Admin -->
      <?php if ($_SESSION['role'] == 'admin') { ?>
        <li class="nav-item">
          <a href=" <?= ADMIN_URL ?>/doctor_list.php" class="nav-link <?php echo ($currentPage == 'doctor_list.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-md"></i>
            <p>Doctor List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= ADMIN_URL ?>/patient_list.php" class="nav-link <?php echo ($currentPage == 'patient_list.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-injured"></i>
            <p>Patient List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href=" <?= ADMIN_URL ?>/adminappointment_details.php" class="nav-link <?php echo ($currentPage == 'adminappointment_details.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Appointment Details</p>
          </a>
        </li>
        <li class="nav-item">
          <a href=" <?= ADMIN_URL ?>/add_doctor.php" class="nav-link <?php echo ($currentPage == 'add_doctor.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>Add Doctor</p>
          </a>
        </li>
        <li class="nav-item">
          <a href=" <?= ADMIN_URL ?>/messages.php" class="nav-link <?php echo ($currentPage == 'messages.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Messages</p>
          </a>
        </li>
      <?php } ?>

      <!-- Menu Visible to All -->
      <!-- <li class="nav-item">
        <a href="profile.php" class="nav-link <?php echo ($currentPage == 'profile.php') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-user"></i>
          <p>Profile</p>
        </a>  
      </li> -->
      <li class="nav-item">
        <a href="<?= BASE_URL ?>/auth/change_password.php" class="nav-link <?php echo ($currentPage == 'change_password.php') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-key"></i>
          <p>Change Password</p>
        </a>
      </li>
      <!-- Logout Menu -->
      <li class="nav-item">
        <a href="/auth/logout.php" class="nav-link">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>Logout</p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</aside>