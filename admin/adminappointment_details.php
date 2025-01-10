<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['aptid'])) {
  $aptid = $_GET['aptid'];

  $sql = "DELETE FROM appointmenttb WHERE aptid = :aptid";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':aptid', $aptid);
  if ($stmt->execute()) {
    header("Location: " . ADMIN_URL . "/adminappointment_details.php?message=Appointment Deleted Successfully");
    exit();
  } else {
    echo "Error: Could not delete the appointment.";
  }
} else {
  echo "Error: Something went wrong.";
}

include("../layout/header.php");
include("../layout/sidebar.php");
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Appointment List</h1>
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
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM appointmenttb";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  foreach ($appointments as $appointment) {
                    echo "<tr>";
                    echo "<td>" . $appointment['aptid'] . "</td>";
                    echo "<td>" . $appointment['patfname'] . " " . $appointment['patlname'] . "</td>";
                    echo "<td>" . $appointment['email'] . "</td>";
                    echo "<td>" . $appointment['contact'] . "</td>";
                    echo "<td>" . $appointment['docfname'] . " " . $appointment['doclname'] . "</td>";
                    echo "<td>" . $appointment['docFees'] . "</td>";
                    echo "<td>" . $appointment['appdate'] . "</td>";
                    echo "<td>" . $appointment['apptime'] . "</td>";

                    // Delete Button
                    echo '<td><a href="adminappointment_details.php?aptid=' . $appointment['aptid'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this Appointment?\');">Delete Appointment</a></td>';
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div><!-- /.card-body -->
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<?php
include("../layout/footer.php");
?>