<?php

require_once('../dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

$patient_id = $_SESSION['patient_id'];

try {
  $sql = "
    SELECT p.docfname, p.doclname, p.aptid, p.appdate, p.apptime, p.disease, p.allergies, p.prescription, p.is_paid,
           a.patfname, a.patlname, a.docFees
    FROM prestb p
    INNER JOIN appointmenttb a ON p.aptid = a.aptid
    WHERE p.pid = :pid
    ORDER BY p.appdate DESC, p.apptime DESC
  ";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':pid', $patient_id, PDO::PARAM_INT);
  $stmt->execute();
  $prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($prescriptions)) {
    $prescriptions = [];
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit;
}

// For Bill Payment Submission
if (isset($_POST['submit_payment'])) {
  $aptid = isset($_POST['aptid']) ? $_POST['aptid'] : null;
  $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
  $payment_details = isset($_POST['payment_details']) ? $_POST['payment_details'] : '';

  if ($aptid === null || empty($payment_method) || empty($payment_details)) {
    echo "<div class='alert alert-danger'>Payment details are missing! Please fill all fields.</div>";
    exit;
  }

  $payment_method = htmlspecialchars($payment_method);
  $payment_details = htmlspecialchars($payment_details);

  try {
    $updateSql = "
      UPDATE prestb 
      SET is_paid = 1, 
          payment_method = :payment_method, 
          payment_details = :payment_details 
      WHERE aptid = :aptid AND pid = :pid
    ";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':aptid', $aptid, PDO::PARAM_STR);
    $updateStmt->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
    $updateStmt->bindParam(':payment_details', $payment_details, PDO::PARAM_STR);
    $updateStmt->bindParam(':pid', $patient_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
      echo "<div class='alert alert-success'>Payment successful! Your payment method: <strong>" . ucfirst($payment_method) . "</strong> has been recorded.</div>";
      header("refresh:2;url=pat_prescription.php");
      exit;
    } else {
      echo "<div class='alert alert-danger'>Error processing payment. Please try again.</div>";
    }
  } catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
  }
}
