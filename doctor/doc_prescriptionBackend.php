<?php

require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$doctor_id = isset($_SESSION['doctor_id']) ? $_SESSION['doctor_id'] : null;

try {
  //Fetch the prescription details from prescriptiontb
  $sql = "
      SELECT pid, patfname, patlname, aptid,  appdate, apptime, disease, allergies, prescription
      FROM prestb 
      WHERE did = :did
      ORDER BY appdate DESC, apptime DESC
    ";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':did', $doctor_id, PDO::PARAM_INT);
  $stmt->execute();
  $prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (empty($prescriptions)) {
    $prescriptions = [];
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit;
}
