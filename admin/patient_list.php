<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];

  $sql = "DELETE FROM patreg WHERE pid = :pid";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':pid', $pid);
  if ($stmt->execute()) {
    header("Location: patient_list.php?message=Patient Deleted Successfully");
    exit();
  } else {
    "Error: Could not delete the patient.";
  }
} else {
  "Error: Something went wrong.";
}

include("../layout/header.php");
include("../layout/sidebar.php");
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Patient List</h1>
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
                    <th scope="col">Patient Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $stmt = $conn->prepare("SELECT * FROM patreg");
                  $stmt->execute();
                  $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  foreach ($patients as $patient) {
                    echo "<tr>";
                    echo "<td>" . $patient['patfname'] . " " . $patient['patlname'] . "</td>";
                    echo "<td>" . $patient['gender'] . "</td>";
                    echo "<td>" . $patient['email'] . "</td>";
                    echo "<td>" . $patient['contact'] . "</td>";

                    // Delete Button
                    echo '<td><a href="patient_list.php?pid=' . $patient['pid'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this patient?\');">Delete Patient</a></td>';
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<?php
include("../layout/footer.php");
?>