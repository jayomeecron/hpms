<?php
include_once('dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $contact = trim($_POST['contact']);
  $subject = trim($_POST['subject']);
  $message = trim($_POST['message']);

  if (!empty($username) && !empty($email) && !empty($contact) && !empty($subject) && !empty($message)) {

    $sql = "INSERT INTO inquiry (username, email, contact, subject, message) VALUES (:username, :email, :contact, :subject, :message)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":contact", $contact);
      $stmt->bindParam(":subject", $subject);
      $stmt->bindParam(":message", $message);

      if ($stmt->execute()) {
        header("Location: contactus.php?status=success");
        exit();
      } else {
        error_log("Database Error: " . $stmt->errorInfo()[2]);
        header("Location: contactus.php?status=error");
        exit();
      }
    } else {
      error_log("SQL Preparation Error: " . $conn->errorInfo()[2]);
      header("Location: contactus.php?status=error");
      exit();
    }
  } else {
    header("Location: contactus.php?status=empty");
    exit();
  }
}
