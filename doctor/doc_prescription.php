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

require_once 'doc_prescriptionBackend.php';

?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Prescriptions</h1>
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
                    <th scope="col">Patient ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescribe</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($prescriptions)) : ?>
                    <?php foreach ($prescriptions as $prescription) : ?>
                      <tr>
                        <td><?php echo $prescription['pid']; ?></td>
                        <td><?php echo $prescription['patfname']; ?></td>
                        <td><?php echo $prescription['patlname']; ?></td>
                        <td><?php echo $prescription['aptid']; ?></td>
                        <td><?php echo $prescription['appdate']; ?></td>
                        <td><?php echo $prescription['apptime']; ?></td>
                        <td><?php echo $prescription['disease']; ?></td>
                        <td><?php echo $prescription['allergies']; ?></td>
                        <td>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#prescriptionModal<?php echo $prescription['aptid']; ?>">View</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="9" class="text-center">No prescriptions found.</td>
                    </tr>
                  <?php endif; ?>
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


<!-- Modal for Prescription View -->
<?php if (!empty($prescriptions)) : ?>
  <?php foreach ($prescriptions as $prescription) : ?>
    <div class="modal fade" id="prescriptionModal<?php echo $prescription['aptid']; ?>" tabindex="-1" role="dialog" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="prescriptionModalLabel">Prescription Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>Patient ID:</strong> <?php echo $prescription['pid']; ?></p>
            <p><strong>Appointment ID:</strong> <?php echo $prescription['aptid']; ?></p>
            <p><strong>Appointment Date:</strong> <?php echo $prescription['appdate']; ?></p>
            <p><strong>Appointment Time:</strong> <?php echo $prescription['apptime']; ?></p>
            <p><strong>Disease:</strong> <?php echo $prescription['disease']; ?></p>
            <p><strong>Allergies:</strong> <?php echo $prescription['allergies']; ?></p>
            <p><strong>Prescription:</strong></p>
            <pre><?php echo $prescription['prescription']; ?></pre>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>