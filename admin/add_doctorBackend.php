<?php
header("Content-Type: text/plain");

require_once('../dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);
  $email = trim($_POST['email']);
  $contact = trim($_POST['contact']);
  $password = trim($_POST['password']);
  $specialization = trim($_POST['spec']);
  $fees = trim($_POST['fees']);

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $checkedQuery = "SELECT * FROM doctreg WHERE email = :email OR contact = :contact";
  $stmt = $conn->prepare($checkedQuery);
  $stmt->bindParam(":email", $email, PDO::PARAM_STR);
  $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo "Email or contact already exists";
  } else {
    $insertQuery = "INSERT INTO doctreg (docfname, doclname, email, contact, password, spec, docFees, session_id) VALUES (:docfname, :doclname, :email, :contact, :password, :spec, :docFees, :session_id)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bindParam(":docfname", $firstName, PDO::PARAM_STR);
    $stmt->bindParam(":doclname", $lastName, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);
    $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(":spec", $specialization, PDO::PARAM_STR);
    $stmt->bindParam(":docFees", $fees, PDO::PARAM_STR);
    $session_id = session_id();
    $stmt->bindParam(":session_id", $session_id, PDO::PARAM_STR);

    if ($stmt->execute()) {
      echo "Registration successful";
    } else {
      echo "Registration failed";
    }
  }
}
