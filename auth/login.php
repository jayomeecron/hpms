<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../dbcon.php');


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
  <title>Login Form</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/dist/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
  <link rel="stylesheet" href="<?= BASE_URL ?>/dist/css/adminlte.min.css">
  <style>
    /* Custom CSS to make validation errors red */
    .is-invalid {
      border-color: red !important;
    }

    .invalid-feedback {
      color: red !important;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Global</b>Hospitals</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login to start your session</p>
        <form id="loginform">
          <div class="form-group">
            <select class="form-control" id="user_role" name="user_role">
              <option value="" selected disabled>Select User Role</option>
              <option value="admin">Admin</option>
              <option value="patient">Patient</option>
              <option value="doctor">Doctor</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" id="login-email" name="email" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="login-password" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mb-1">
          <a href="#">I forgot my password</a>
        </p>
        <p class="mb-0">
          <a href="register.php" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

  <script>
    var baseURL = "<?php echo BASE_URL; ?>";
    $(document).ready(function() {
      $("#loginform").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 5
          },
          user_role: {
            required: true
          }
        },
        messages: {
          email: {
            required: "Please enter an email address",
            email: "Please enter a valid email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          },
          user_role: {
            required: "Please select a user role"
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
        },
        highlight: function(element) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
          $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
          // Collect form data
          var email = $("#login-email").val();
          var password = $("#login-password").val();
          var admin = $("#user_role").val();

          $.ajax({
            url: "backend.php",
            type: "POST",
            data: {
              email: email,
              password: password,
              action: "login",
              role: admin,
            },
            success: function(response) {
              var data = JSON.parse(response);

              if (data.status === "success") {
                alert(data.message);
                window.location.href = baseURL + "/dashboard.php";
              } else {
                alert(data.message);
              }
            },
            error: function(xhr, status, error) {
              alert("An error occurred: " + error);
            }
          });
        }
      });
    });
  </script>
</body>

</html>