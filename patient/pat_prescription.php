<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../layout/header.php");
include("../layout/sidebar.php");

require_once 'pat_prescriptionBackend.php';

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
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescriptions</th>
                    <th scope="col">Bill Payment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($prescriptions)) : ?>
                    <?php foreach ($prescriptions as $prescription) : ?>
                      <tr>
                        <td><?php echo $prescription['docfname'] . ' ' . $prescription['doclname']; ?></td>
                        <td><?php echo $prescription['aptid']; ?></td>
                        <td><?php echo $prescription['appdate']; ?></td>
                        <td><?php echo $prescription['apptime']; ?></td>
                        <td><?php echo $prescription['disease']; ?></td>
                        <td><?php echo $prescription['allergies']; ?></td>
                        <td>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#prescriptionModal<?php echo $prescription['aptid']; ?>">View</button>
                        </td>
                        <td>
                          <?php if (isset($prescription['is_paid']) && $prescription['is_paid'] == 1) : ?>
                            <!-- If bill is paid, show 'Bill Paid' and disable button -->
                            <button class="btn btn-success" disabled>Bill Paid</button>
                          <?php else : ?>
                            <!-- If bill is not paid, show 'Pay Bill' button -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal<?php echo $prescription['aptid']; ?>">Bill Pay</button>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="8" class="text-center">No prescriptions found for this patient.</td>
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
          <p><strong>Doctor:</strong> <?php echo $prescription['docfname'] . ' ' . $prescription['doclname']; ?></p>
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

<!-- Modal for Bill Payment -->
<?php foreach ($prescriptions as $prescription) : ?>
  <div class="modal fade" id="paymentModal<?php echo $prescription['aptid']; ?>" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Bill Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="pat_prescriptionBackend.php" method="POST">
            <!-- Hidden fields to send relevant data -->
            <input type="hidden" name="aptid" value="<?php echo $prescription['aptid']; ?>">
            <!-- <input type="hidden" name="pid" value="<?php echo $_SESSION['pid']; ?>"> -->

            <p><strong>Appointment ID:</strong> <?php echo $prescription['aptid']; ?></p>
            <p><strong>Doctor Name:</strong> <?php echo $prescription['docfname'] . ' ' . $prescription['doclname']; ?></p>
            <p><strong>Patient Name:</strong> <?php echo $prescription['patfname'] . ' ' . $prescription['patlname']; ?></p>
            <p><strong>Appointment Date:</strong> <?php echo $prescription['appdate']; ?></p>
            <p><strong>Appointment Time:</strong> <?php echo $prescription['apptime']; ?></p>
            <p><strong>Total Fees:</strong> ₹<?php echo $prescription['docFees']; ?></p>

            <!-- Payment Method -->
            <div class="form-group">
              <label for="paymentMethod">Payment Method</label>
              <select class="form-control" id="paymentMethod" name="payment_method" required>
                <option value="" disabled selected>Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="net_banking">Net Banking</option>
                <option value="upi">UPI</option>
                <option value="cash">Cash</option>
              </select>
            </div>

            <div class="form-group">
              <label for="paymentDetails">Payment Details</label>
              <input type="text" class="form-control" id="paymentDetails" name="payment_details" placeholder="Enter Card/UPI Details">
            </div>

            <!-- Billing Notes -->
            <div class="form-group">
              <label for="billingNotes">Billing Notes (Optional)</label>
              <textarea class="form-control" id="billingNotes" name="billing_notes" rows="3" placeholder="Any additional comments"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-center">
              <button type="submit" class="btn btn-success" name="submit_payment">Pay Now</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- <script>
  function validatePaymentForm(form) {
    var paymentMethod = form['payment_method'].value;
    var paymentDetails = form['payment_details'].value;

    if (!paymentMethod) {
      alert("Please select a payment method.");
      return false;
    }

    if (!paymentDetails) {
      alert("Please enter payment details.");
      return false;
    }

    return true;
  }
</script> -->