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

$role = $_SESSION['role'] ?? null;
$doctorQuery = "SELECT * FROM doctreg WHERE session_id = :session_id";
$stmt = $conn->prepare($doctorQuery);
$session_id = session_id();
$stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
$stmt->execute();
$doctors = $stmt->fetchAll();

?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Book Your Appointment</h1>
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
              <div class="appointment-form">
                <form id="appointmentForm">
                  <div class="form-group">
                    <label for="specialization">Specialization:</label>
                    <select id="specialization" class="form-control" name="spec" required>
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
                      <option value="Gynecologist">Gynecologist</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="doctor">Doctors:</label>
                    <select id="doctor" class="form-control" name="doctor" required>
                      <option value="" disabled selected>Select a Doctor</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="fees">Consultancy Fees</label>
                    <input type="text" id="fees" class="form-control" readonly name="fees">
                  </div>

                  <div class="form-group">
                    <label for="appdate">Date</label>
                    <input type="date" id="appdate" class="form-control" name="appdate" required>
                  </div>

                  <div class="form-group">
                    <label for="apptime">Time</label>
                    <input type="time" id="apptime" class="form-control" name="apptime" required>
                  </div>

                  <button type="submit" class="btn btn-primary">Create New Appointment</button>
                  <div id="statusMessage"></div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $('#specialization').change(function() {
    var specialization = $(this).val();

    $('#doctor').html('<option value="" disabled selected>Select a Doctor</option>');
    $('#fees').val('');

    if (specialization) {
      $.ajax({
        url: 'appointmentBackend.php',
        type: 'POST',
        data: {
          specialization: specialization
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.status === 'success') {
            var doctorOptions = data.doctors.map(function(doctor) {
              return `<option 
                          ${doctor.docfname} ${doctor.doclname}
                          data-docfees="${doctor.docFees}"
                          value="${doctor.did}">
                          ${doctor.docfname} ${doctor.doclname} (${doctor.spec})
                      </option>`;
            });
            $('#doctor').html(
              `<option value="" disabled selected>Select a Doctor</option>${doctorOptions.join('')}`
            );
          } else {
            alert(data.message);
          }
        },
        error: function() {
          alert('Failed to fetch doctors. Please try again.');
        }
      });
    }
  });

  // Set consultancy fees when a doctor is selected
  $('#doctor').change(function() {
    var docFees = $(this).find('option:selected').data('docfees');
    $('#fees').val(docFees);
  });

  $('#appointmentForm').submit(function(e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $('#statusMessage').html('<span class="text-info">Processing...</span>');

    $.ajax({
      url: 'appointmentBackend.php',
      type: 'POST',
      data: formData,
      success: function(response) {
        var res = JSON.parse(response);
        if (res.status === 'success') {
          $('#statusMessage').html('<span class="text-success">' + res.message + '</span>');
          $('#appointmentForm')[0].reset();
        } else {
          $('#statusMessage').html('<span class="text-danger">' + res.message + '</span>');
        }
      },
      error: function() {
        $('#statusMessage').html('<span class="text-danger">An error occurred. Please try again.</span>');
      }
    });
  });
</script>

<?php
include("../layout/footer.php");
?>