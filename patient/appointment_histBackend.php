<?php

require_once('../dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['patient_id'])) {
  header("Location: login.php");
  exit();
}

$patient_id = $_SESSION['patient_id'];

try {
  // Fetch the appointment details from appointmenttb
  $sql = "
      SELECT aptid, docfname, doclname, docFees, appdate, apptime, userStatus, doctorStatus
      FROM appointmenttb
      WHERE pid = :pid
      ORDER BY appdate DESC, apptime DESC
    ";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':pid', $patient_id, PDO::PARAM_INT);
  $stmt->execute();
  $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($appointments)) {
    $appointments = [];
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit;
}


// Check if the cancellation request was made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aptid'])) {
  $aptid = $_POST['aptid'];

  try {
    // Check if the appointment exists and belongs to this patient
    $checkSql = "SELECT did, doctorStatus FROM appointmenttb WHERE aptid = :aptid AND pid = :pid";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':aptid', $aptid, PDO::PARAM_STR);
    $checkStmt->bindParam(':pid', $patient_id, PDO::PARAM_INT);
    $checkStmt->execute();
    $appointment = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment && $appointment['doctorStatus'] == 1) {
      // Cancelled by Patient
      $updateSql = "UPDATE appointmenttb SET doctorStatus = 1, userStatus = 0 WHERE aptid = :aptid";

      $updateStmt = $conn->prepare($updateSql);
      $updateStmt->bindParam(':aptid', $aptid, PDO::PARAM_STR);
      $updateStmt->execute();

      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'This appointment cannot be cancelled.']);
    }
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Cancellation failed: ' . $e->getMessage()]);
  }
  exit;
}
