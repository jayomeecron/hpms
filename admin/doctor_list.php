<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['did'])) {
  $did = $_GET['did'];

  $sql = "DELETE FROM doctreg WHERE did = :did";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':did', $did);

  if ($stmt->execute()) {
    header("Location: doctor_list.php?message=Doctor Deleted Successfully");
    exit();
  } else {
    echo "Error: Could not delete the doctor.";
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
          <h1 class="m-0">Doctor List</h1>
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
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Doctor email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM doctreg";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  foreach ($doctors as $doctor) {
                    echo "<tr>";
                    echo "<td>" . $doctor['docfname'] . " " . $doctor['doclname'] . "</td>";
                    echo "<td>" . $doctor['email'] . "</td>";
                    echo "<td>" . $doctor['contact'] . "</td>";
                    echo "<td>" . $doctor['spec'] . "</td>";
                    echo "<td>" . $doctor['docFees'] . "</td>";
                    // Delete Button
                    echo '<td><a href="doctor_list.php?did=' . $doctor['did'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this doctor?\');">Delete Doctor</a></td>';
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