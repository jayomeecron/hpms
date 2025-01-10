<?php
require_once('../dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Get Appointment ID
$aptid = isset($_GET['aptid']) ? $_GET['aptid'] : null;

if (!$aptid) {
  echo "Invalid appointment ID.";
  exit();
}

include("../layout/header.php");
include("../layout/sidebar.php");
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h3>Prescription for Appointment ID: <span style="color: blue;"><?php echo $aptid; ?></span></h3>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <form id="prescriptionForm">
        <div class="form-group">
          <label for="disease">Disease</label>
          <input type="text" class="form-control" id="disease" name="disease" placeholder="Enter the disease">
        </div>
        <div class="form-group">
          <label for="allergies">Allergies</label>
          <input type="text" class="form-control" id="allergies" name="allergies" placeholder="Enter any allergies">
        </div>
        <div class="form-group">
          <label for="prescription">Prescription</label>
          <textarea class="form-control" id="prescription" name="prescription" rows="5" placeholder="Enter prescription details and advice"></textarea>
        </div>
        <input type="hidden" name="aptid" value="<?php echo $aptid; ?>">
        <button type="submit" class="btn btn-success">Submit Prescription</button>
      </form>
    </div>
  </section>
</div>

<?php
include("../layout/footer.php");
?>

<script>
  $('#prescriptionForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
      url: 'save_prescription.php',
      type: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        var res = JSON.parse(response);
        if (res.status === 'success') {
          alert('Prescription saved successfully.');
          window.location.href = 'doc_prescription.php';
        } else {
          alert(res.message);
        }
      },
      error: function() {
        alert('An error occurred. Please try again.');
      }
    });
  });
</script>