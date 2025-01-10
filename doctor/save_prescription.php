  <?php

  require_once('../dbcon.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  if (!validateSession()) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aptid = $_POST['aptid'] ?? null;
    $disease = $_POST['disease'] ?? null;
    $allergies = $_POST['allergies'] ?? null;
    $prescription = $_POST['prescription'] ?? null;


    $query = "SELECT docfname, doclname, did, patfname, patlname, pid, appdate, apptime 
                FROM appointmenttb 
                WHERE aptid = :aptid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':aptid', $aptid, PDO::PARAM_STR);
    $stmt->execute();

    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
      echo json_encode(['status' => 'error', 'message' => 'Invalid appointment ID.']);
      exit();
    }

    // Extract appointment details
    $docfname = $appointment['docfname'];
    $doclname = $appointment['doclname'];
    $did = $appointment['did'];
    $patfname = $appointment['patfname'];
    $patlname = $appointment['patlname'];
    $pid = $appointment['pid'];
    $appdate = $appointment['appdate'];
    $apptime = $appointment['apptime'];

    $sql = "INSERT INTO prestb (docfname, doclname, did, pid, aptid, patfname, patlname, appdate, apptime, disease, allergies, prescription, is_paid, payment_method, payment_details) 
              VALUES (:docfname, :doclname, :did, :pid, :aptid, :patfname, :patlname, :appdate, :apptime, :disease, :allergies, :prescription, :is_paid, :payment_method, :payment_details)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':docfname', $docfname, PDO::PARAM_STR);
    $stmt->bindParam(':doclname', $doclname, PDO::PARAM_STR);
    $stmt->bindParam(':did', $did, PDO::PARAM_INT);
    $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
    $stmt->bindParam(':aptid', $aptid, PDO::PARAM_STR);
    $stmt->bindParam(':patfname', $patfname, PDO::PARAM_STR);
    $stmt->bindParam(':patlname', $patlname, PDO::PARAM_STR);
    $stmt->bindParam(':appdate', $appdate, PDO::PARAM_STR);
    $stmt->bindParam(':apptime', $apptime, PDO::PARAM_STR);
    $stmt->bindParam(':disease', $disease, PDO::PARAM_STR);
    $stmt->bindParam(':allergies', $allergies, PDO::PARAM_STR);
    $stmt->bindParam(':prescription', $prescription, PDO::PARAM_STR);
    $stmt->bindParam(':is_paid', $is_paid, PDO::PARAM_BOOL);
    $stmt->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
    $stmt->bindParam(':payment_details', $payment_details, PDO::PARAM_STR);

    if ($stmt->execute()) {
      echo json_encode(['status' => 'success', 'message' => 'Prescription saved successfully.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Error saving prescription: ' . $stmt->errorInfo()[2]]);
    }
  }
