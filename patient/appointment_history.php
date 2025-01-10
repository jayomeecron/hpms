<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: ../auth/login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../layout/header.php");
include("../layout/sidebar.php");

require_once 'appointment_histBackend.php';
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Appointment History</h1>
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
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?>
                      <tr>
                        <td><?php echo $appointment['aptid']; ?></td>
                        <td><?php echo $appointment['docfname'] . ' ' . $appointment['doclname']; ?></td>
                        <td><?php echo $appointment['docFees']; ?></td>
                        <td><?php echo $appointment['appdate']; ?></td>
                        <td><?php echo $appointment['apptime']; ?></td>
                        <td>
                          <?php
                          if ($appointment['userStatus'] == 0 && $appointment['doctorStatus'] == 0) {
                            echo "Cancelled by Doctor";
                          } elseif ($appointment['userStatus'] == 0 && $appointment['doctorStatus'] == 1) {
                            echo "Cancelled by Patient";
                          } else {
                            echo "Active";
                          }
                          ?>
                        </td>
                        <td>
                          <?php if ($appointment['userStatus'] == 1): ?>
                            <button class="btn btn-danger cancelBtn" data-aptid="<?php echo $appointment['aptid']; ?>" data-toggle="modal" data-target="#confirmCancelModal">Cancel</button>
                          <?php else: ?>
                            <button class="btn btn-secondary" disabled>Cancelled</button>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="12" class="text-center">No appointments found.</td>
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

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" role="dialog" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmCancelModalLabel">Confirm Cancellation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel this appointment?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirmCancel">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>

<?php
include("../layout/footer.php");
?>

<script>
  var aptidToCancel;

  $('.cancelBtn').click(function() {
    aptidToCancel = $(this).data('aptid');
    console.log('Appointment ID:', aptidToCancel);
  });

  // Confirm cancellation
  $('#confirmCancel').click(function() {
    console.log('Confirm Cancel:', aptidToCancel);
    $.ajax({
      url: 'appointment_histBackend.php',
      type: 'POST',
      data: {
        aptid: aptidToCancel
      },
      success: function(response) {
        var res = JSON.parse(response);
        if (res.status === 'success') {
          location.reload();
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