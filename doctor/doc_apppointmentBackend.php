<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doctor_id = $_SESSION['doctor_id'];

// Fetch all appointments for the doctor, ordered by appointment date and time
try {
  $sql = "SELECT aptid, pid, patfname, patlname, gender, email, contact, appdate, apptime, userStatus, doctorStatus, docFees, spec 
          FROM appointmenttb 
          WHERE did = :did 
          ORDER BY appdate DESC, apptime DESC";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':did', $doctor_id, PDO::PARAM_INT);
  $stmt->execute();
  $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($appointments)) {
    echo json_encode(['status' => 'error', 'message' => 'No appointments found for this doctor.']);
    exit;
  }
} catch (PDOException $e) {
  echo json_encode(['status' => 'error', 'message' => 'Query error: ' . $e->getMessage()]);
  exit;
}

// Check if the cancellation request was made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aptid'])) {
  $aptid = $_POST['aptid'];

  if (!isset($aptid) || empty($aptid)) {
    echo json_encode(['status' => 'error', 'message' => 'No appointment ID received.']);
    exit;
  }

  try {
    // Check if the appointment exists and belongs to this doctor
    $checkSql = "SELECT pid, userStatus FROM appointmenttb WHERE aptid = :aptid AND did = :did";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':aptid', $aptid, PDO::PARAM_STR);
    $checkStmt->bindParam(':did', $doctor_id, PDO::PARAM_INT);
    $checkStmt->execute();
    $appointment = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment && $appointment['userStatus'] == 1) {
      // Cancelled by Doctor
      $updateSql = "UPDATE appointmenttb SET doctorStatus = 0, userStatus = 0 WHERE aptid = :aptid";

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

// Prepare data to send to the front-end
echo json_encode([
  'status' => 'success',
  'appointments' => $appointments
]);
