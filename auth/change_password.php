<?php

require_once('../dbcon.php'); // Path to dbcon.php (Root folder)

if (!validateSession()) {
  header("Location: ./login.php"); // Path to login.php (same auth folder)
  exit();
}

$message = "";

$role = $_SESSION['role'];
include(__DIR__ . '/../layout/header.php'); // Path to header.php (layout folder)
include(__DIR__ . '/../layout/sidebar.php'); // Path to sidebar.php (layout folder)
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Change Password (<?= ucfirst($role) ?>)</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <?php if (!empty($message)) echo $message; ?>
              <form id="changePasswordForm">
                <div class="form-group">
                  <label for="currentPassword">Current Password</label>
                  <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter Current Password" required>
                </div>
                <div class="form-group">
                  <label for="newPassword">New Password</label>
                  <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter New Password" required>
                </div>
                <div class="form-group">
                  <label for="confirmPassword">Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                </div>
                <button type="button" id="changePasswordBtn" class="btn btn-primary">Change Password</button>
              </form>

              <div id="responseMessage" style="margin-top: 15px;"></div>

            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<script>
  $(document).ready(function() {
    $('#changePasswordBtn').click(function(e) {
      e.preventDefault();

      var currentPassword = $('#currentPassword').val();
      var newPassword = $('#newPassword').val();
      var confirmPassword = $('#confirmPassword').val();

      if (currentPassword === "" || newPassword === "" || confirmPassword === "") {
        $('#responseMessage').html('<div class="alert alert-danger">Please enter all fields.</div>');
        return;
      }

      if (newPassword !== confirmPassword) {
        $('#responseMessage').html('<div class="alert alert-danger">New Password and Confirm Password do not match.</div>');
        return;
      }

      if (newPassword.length < 8) {
        $('#responseMessage').html('<div class="alert alert-danger">Password must be at least 8 characters long.</div>');
        return;
      }

      $.ajax({
        url: './backend.php', 
        method: 'POST',
        data: $('#changePasswordForm').serialize() + '&action=change_password', 
        success: function(response) {
          try {
            var res = JSON.parse(response);

            if (res.status === "success") {
              $('#responseMessage').html('<div class="alert alert-success">' + res.message + '</div>');

              setTimeout(function() {
                window.location.reload();
              }, 1000);
            } else if (res.status === "error") {
              $('#responseMessage').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
          } catch (e) {
            $('#responseMessage').html('<div class="alert alert-danger">Invalid response from server.</div>');
          }
        },
        error: function() {
          $('#responseMessage').html('<div class="alert alert-danger">Something went wrong. Please try again later.</div>');
        },
      });
    });
  });
</script>

<?php
include(__DIR__ . '/../layout/footer.php'); // Path to footer.php (layout folder)
?>