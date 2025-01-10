<?php
require_once("../dbcon.php");

if (validateSession()) {
  header("Location: " . BASE_URL . "/dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/dist/css/adminlte.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body,
    .register-box {
      font-family: 'Source Sans Pro', sans-serif;
    }
  </style>
</head>

<body>
  <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); height: auto; width: 500px;" class="register-box">
    <div class="register-logo">
      <div style="text-align: center;"><a href="#"><b>Global</b>Hospital</a></div>
    </div>

    <!-- User Role Selection -->
    <!-- Commenting out role selection as we only want patient registration
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Select a role to register</p>
        <div class="input-group mb-3">
          <select class="form-control" id="user_role" name="user_role" required>
            <option value="" selected disabled>Select User Role</option>
            <option value="admin">Admin</option>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
          </select>
        </div>
      </div>
    </div>
    -->

    <!-- Form Templates -->
    <!-- Commenting out admin form for future use
    <div class="card" id="adminForm" style="display: none;">
      <!-- Admin Form -->
      <!--<div class="card-body register-card-body">
        <p class="login-box-msg">Register a new <strong>Admin</strong></p>
        <form id="adminRegistrationForm">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" required>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="admin_agreeTerms" name="terms" value="agree" required>
                <label for="admin_agreeTerms"> I agree to the <a href="term.php">terms</a></label>
                <p style="margin-top: 10px;" class="mb-0">
                  <a href="login.php" class="text-center">Already have an account? Login</a>
                </p>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    -->

    <!-- Commenting out doctor form for future use
    <div class="card" id="doctorForm" style="display: none;">
      <!-- Doctor Form -->
      <!--<div class="card-body register-card-body">
        <p class="login-box-msg">Register a new <strong>Doctor</strong></p>
        <form id="doctorRegistrationForm">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="First Name" name="docfname" required>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Last Name" name="doclname" required>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="Phone Number" name="contact" required>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="spec" required>
              <option value="" disabled selected>Select Specialization</option>
              <option value="General">General</option>
              <option value="Cardiologist">Cardiologist</option>
              <option value="Dermatologist">Dermatologist</option>
              <option value="Pediatrician">Pediatrician</option>
              <option value="Neurologist">Neurologist</option>
              <option value="Orthopedic">Orthopedic</option>
              <option value="Ophthalmologist">Ophthalmologist</option>
              <option value="Oncologist">Oncologist</option>
              <option value="Radiologist">Radiologist</option>
              <option value="Surgeon">Surgeon</option>
              <option value="Urologist">Urologist</option>
              <option value="Urologist">gynecologist</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="fees" name="docFees" required>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="doctor_agreeTerms" name="terms" value="agree" required>
                <label for="doctor_agreeTerms"> I agree to the <a href="term.php">terms</a></label>
                <p style="margin-top: 10px;" class="mb-0">
                  <a href="login.php" class="text-center">Already have an account? Login</a>
                </p>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    -->

    <div class="card" id="patientForm"><!-- Removed style="display: none;" to show form by default -->
      <!-- Patient Form -->
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new <strong>Patient</strong></p>
        <form id="patientRegistrationForm">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="First Name" name="patfname" required>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Last Name" name="patlname" required>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="Phone Number" name="contact" required>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="gender" required>
              <option value="" selected disabled>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="patient_agreeTerms" name="terms" value="agree" required>
                <label for="patient_agreeTerms"> I agree to the <a href="term.php">terms</a></label>
                <p style="margin-top: 10px;" class="mb-0">
                  <a href="login.php" class="text-center">Already have an account? Login</a>
                </p>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    var baseURL = "<?php echo BASE_URL; ?>";

    // Commenting out role selection logic since we're only showing patient form
    /*
    $(document).ready(function() {
      $('#user_role').change(function() {
        // Hide all forms first
        $('#adminForm, #doctorForm, #patientForm').hide();
        
        // Show the selected form
        var selectedRole = $(this).val();
        if (selectedRole) {
          $('#' + selectedRole + 'Form').show();
        }
      });
    });
    */

    // Form submission handlers
    $(document).ready(function() {
      /* Commenting out admin form handler for future use
      $('#adminRegistrationForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=register&role=admin';
        submitRegistrationForm(formData);
      });
      */

      /* Commenting out doctor form handler for future use
      $('#doctorRegistrationForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=register&role=doctor';
        submitRegistrationForm(formData);
      });
      */

      $('#patientRegistrationForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=register&role=patient';
        submitRegistrationForm(formData);
      });
    });

    function submitRegistrationForm(formData) {
      $.ajax({
        url: "backend.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
          console.log(response);
          alert(response.message);
          setTimeout(function() {
            window.location.href = baseURL + "/auth/login.php";
          }, 1000);
        },
        error: function() {
          alert("An error occurred. Please try again.");
        }
      });
    }
  </script>

</body>

</html>