<?php
include_once('dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate session and role
if (!validateSession()) {
  echo json_encode([]);
  exit();
}

if ($_SESSION['role'] == 'patient' && !isset($_SESSION['patient_id'])) {
  echo json_encode([]);
  exit();
}

if ($_SESSION['role'] == 'doctor' && !isset($_SESSION['doctor_id'])) {
  echo json_encode([]);
  exit();
}

$appointments = [];

if ($_SESSION['role'] == 'patient') {
  $pid = $_SESSION['patient_id'];

  $query = "SELECT aptid, appdate, apptime, docfname, doclname FROM appointmenttb WHERE pid = ?";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $pid, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($result)) {
    echo json_encode([]);
    exit();
  }

  foreach ($result as $row) {
    $appointments[] = [
      'aptid' => $row['aptid'],
      'title' => 'Appointment with Dr. ' . $row['docfname'] . ' ' . $row['doclname'],
      'start' => $row['appdate'] . 'T' . $row['apptime'],
    ];
  }
} elseif ($_SESSION['role'] == 'doctor') {
  $did = $_SESSION['doctor_id'];
  $query = "SELECT aptid, appdate, apptime, patfname, patlname FROM appointmenttb WHERE did = ?";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $did, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($result)) {
    echo json_encode([]);
    exit();
  }

  foreach ($result as $row) {
    $appointments[] = [
      'aptid' => $row['aptid'],
      'title' => 'Appointment with ' . $row['patfname'] . ' ' . $row['patlname'],
      'start' => $row['appdate'] . 'T' . $row['apptime'],
    ];
  }
}

echo json_encode($appointments);
$stmt->closeCursor();
$conn = null;
