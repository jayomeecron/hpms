<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../layout/header.php");
include("../layout/sidebar.php");
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Add Doctor</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form id="doctorRegistrationForm">
                <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter Doctor's First Name">
                </div>

                <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Doctor's Last Name">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter Doctor's Email">
                </div>
                <div class="form-group">
                  <label for="contact">Contact Number</label>
                  <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Doctor's Contact Number">
                </div>
                <div class="form-group">
                  <label for="address">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                </div>
                <div class="form-group">
                  <label for="confirmPassword">Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                  <label for="speclization">Specialization</label>
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
                <div class="form-group">
                  <label for="fees">Consultancy Fees</label>
                  <input type="number" class="form-control" id="fees" name="fees" placeholder="Enter Doctor's Consultancy Fees">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<script>
  $(document).ready(function() {
    $("#doctorRegistrationForm").submit(function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var isValid = true;

      // Reset all fields' error state
      $("#doctorRegistrationForm input, #doctorRegistrationForm select").each(function() {
        $(this).removeClass("is-invalid");
        $(this).attr("placeholder", $(this).data("placeholder"));
      });

      // For empty fields
      $("#doctorRegistrationForm input, #doctorRegistrationForm select").each(function() {
        if ($(this).val() === "" || $(this).val() === null) {
          $(this).addClass("is-invalid");
          $(this).attr("placeholder", "This field is required");
          isValid = false;
        }
      });

      // Check for password mismatch
      var password = $("#password").val();
      var confirmPassword = $("#confirmPassword").val();
      if (password !== confirmPassword) {
        $("#password, #confirmPassword").addClass("is-invalid");
        $("#password").val("").attr("placeholder", "Passwords do not match");
        $("#confirmPassword").val("").attr("placeholder", "Passwords do not match");
        isValid = false;
      }

      if (password.length > 0 && password.length < 8) {
        $("#password").addClass("is-invalid");
        $("#password").val("").attr("placeholder", "Password must be at least 8 characters");
        isValid = false;
      }

      var contact = $("#contact").val();
      if (contact.length > 0 && contact.length !== 10) {
        $("#contact").addClass("is-invalid");
        $("#contact").val("").attr("placeholder", "Contact must be 10 digits");
        isValid = false;
      }

      var fees = $("#fees").val();
      if (fees > 0 && fees < 100) {
        $("#fees").addClass("is-invalid");
        $("#fees").val("").attr("placeholder", "Fees must be greater than 100");
        isValid = false;
      }

      if (!isValid) {
        alert("Please fix the errors before submitting.");
        return false;
      }

      $.ajax({
        url: "add_doctorBackend.php",
        type: "POST",
        data: formData,
        success: function(response) {
          console.log("Response:", response);
          if (response.trim() === "Registration successful") {
            alert("Doctor added successfully!");
            window.location.href = "add_doctor.php";
          } else {
            alert("Failed to add doctor. Please try again.");
          }
        },
        error: function() {
          alert("An error occurred while adding the doctor.");
        },
      });
    });
  });
</script>

<?php
include("../layout/footer.php");
?>