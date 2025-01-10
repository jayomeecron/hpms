<?php
require_once('../dbcon.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['specialization'])) {
    $specialization = $_POST['specialization'];

    try {
      $stmt = $conn->prepare("SELECT did, docfname, doclname, docFees, spec FROM doctreg WHERE spec = ?");
      $stmt->execute([$specialization]);
      $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($doctors) {
        echo json_encode([
          'status' => 'success',
          'doctors' => $doctors
        ]);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'No doctors found for this specialization.']);
      }
    } catch (Exception $e) {
      echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
  }

  // Handle Appointment Booking
  if (isset($_POST['doctor']) && isset($_POST['appdate']) && isset($_POST['apptime'])) {
    $doctorId = $_POST['doctor'];
    $appdate = $_POST['appdate'];
    $apptime = $_POST['apptime'];

    if (empty($doctorId) || empty($appdate) || empty($apptime)) {
      echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
      exit;
    }

    // Ensure user is logged in (session check)
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
      echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
      exit;
    }
    $patientId = $_SESSION['patient_id'] ?? null;
    $patientFname = $_SESSION['patfname'] ?? '';
    $patientLname = $_SESSION['patlname'] ?? '';
    $gender = $_SESSION['gender'] ?? '';
    $email = $_SESSION['email'] ?? '';
    $contact = $_SESSION['contact'] ?? '';


    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    // exit;


    try {
      // Fetch selected doctor details
      $stmt = $conn->prepare("SELECT * FROM doctreg WHERE did = ?");
      $stmt->execute([$doctorId]);
      $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($doctor) {
        $docfname = $doctor['docfname'];
        $doclname = $doctor['doclname'];
        $docFees = $doctor['docFees'];
        $spec = $doctor['spec'];


        $sessionId = session_id();
        $aptid = intval(microtime(true) * 10000);

        // Insert appointment into the database
        $stmt = $conn->prepare("INSERT INTO `appointmenttb` 
        (`pid`, `did`, `aptid`, `patfname`, `patlname`, `gender`, `email`, `contact`, 
        `docfname`, `doclname`, `docFees`, `spec`, `appdate`, `apptime`, `userStatus`, `doctorStatus`) 
        VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
          $patientId,
          $doctorId,
          $aptid,
          $patientFname,
          $patientLname,
          $gender,
          $email,
          $contact,
          $docfname,
          $doclname,
          $docFees,
          $spec,
          $appdate,
          $apptime,
          1,
          1
        ]);


        if ($stmt->rowCount() > 0) {
          echo json_encode(['status' => 'success', 'message' => 'Appointment booked successfully!', 'aptid' => $aptid]);
        } else {
          echo json_encode(['status' => 'error', 'message' => 'Failed to book appointment. Please try again.']);
        }
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Doctor not found.']);
      }
    } catch (Exception $e) {
      echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
