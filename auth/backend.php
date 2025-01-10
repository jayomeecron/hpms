<?php

require_once('../dbcon.php');


if (isset($_POST["action"]) && $_POST['action'] === 'register') {
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_write_close();
  }
  session_regenerate_id();

  $res = [];
  $role = isset($_POST["role"]) ? $_POST["role"] : '';
  $fname = $lname = $email = $contact = $username = $gender = $password = '';

  if ($role === "doctor" || $role === "patient") {
    if ($role === "doctor") {
      $fname = isset($_POST["docfname"]) ? trim($_POST["docfname"]) : '';
      $lname = isset($_POST["doclname"]) ? trim($_POST["doclname"]) : '';
    } elseif ($role === "patient") {
      $fname = isset($_POST["patfname"]) ? trim($_POST["patfname"]) : '';
      $lname = isset($_POST["patlname"]) ? trim($_POST["patlname"]) : '';
    }
    $contact = isset($_POST["contact"]) ? trim($_POST["contact"]) : '';
    $gender = isset($_POST["gender"]) ? trim($_POST["gender"]) : '';
  }

  if ($role === "admin") {
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
  }
  $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
  $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $sessionId = session_id();

  if ($role === "doctor") {
    $specialization = isset($_POST["spec"]) ? trim($_POST["spec"]) : '';
    $fees = isset($_POST["docFees"]) ? trim($_POST["docFees"]) : '';

    $sql = "SELECT * FROM doctreg WHERE email = :email OR contact = :contact";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $res = ["status" => "error", "message" => "A doctor with this email or contact already exists."];
    } else {
      try {
        $sql = "INSERT INTO doctreg (docfname, doclname, email, contact, password, spec, docFees, session_id) 
                VALUES (:docfname, :doclname, :email, :contact, :password, :spec, :docFees, :session_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":docfname", $fname, PDO::PARAM_STR);
        $stmt->bindParam(":doclname", $lname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":spec", $specialization, PDO::PARAM_STR);
        $stmt->bindParam(":docFees", $fees, PDO::PARAM_STR);
        $stmt->bindParam(":session_id", $sessionId, PDO::PARAM_STR);

        if ($stmt->execute()) {
          $res = ["status" => "success", "message" => "Doctor registration successful"];
        } else {
          $res = ["status" => "error", "message" => "Failed to register doctor. Please try again"];
        }
      } catch (PDOException $e) {
        $res = ["status" => "error", "message" => "Database error: " . $e->getMessage()];
      }
    }
  } elseif ($role === "patient") {
    $sql = "SELECT * FROM patreg WHERE email = :email OR contact = :contact";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $res = ["status" => "error", "message" => "A patient with this email or contact already exists."];
    } else {
      try {
        $sql = "INSERT INTO patreg (patfname, patlname, gender, email, contact, password, session_id) 
                VALUES (:patfname, :patlname, :gender, :email, :contact, :password, :session_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":patfname", $fname, PDO::PARAM_STR);
        $stmt->bindParam(":patlname", $lname, PDO::PARAM_STR);
        $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":session_id", $sessionId, PDO::PARAM_STR);

        if ($stmt->execute()) {
          $res = ["status" => "success", "message" => "Patient registration successful"];
        } else {
          $res = ["status" => "error", "message" => "Failed to register patient. Please try again"];
        }
      } catch (PDOException $e) {
        $res = ["status" => "error", "message" => "Database error: " . $e->getMessage()];
      }
    }
  } elseif ($role === "admin") {
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $res = ["status" => "error", "message" => "An admin with this email already exists."];
    } else {
      try {
        $sql = "INSERT INTO user (username, email, password, session_id) 
                        VALUES (:username, :email, :password, :session_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":session_id", $sessionId, PDO::PARAM_STR);

        if ($stmt->execute()) {
          $res = ["status" => "success", "message" => "Admin registration successful"];
        } else {
          $res = ["status" => "error", "message" => "Failed to register admin. Please try again"];
        }
      } catch (PDOException $e) {
        $res = ["status" => "error", "message" => "Database error: " . $e->getMessage()];
      }
    }
  } else {
    $res = ["status" => "error", "message" => "Invalid role selected"];
  }
  echo json_encode($res);
} elseif (isset($_POST["action"]) && $_POST['action'] === 'login') {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);
  $role = trim($_POST["role"]);
  $res = [];

  $table = "";
  $id_column = "";
  $session_column = "session_id";
  switch ($role) {
    case 'admin':
      $table = "user";
      $id_column = "id";
      break;
    case 'doctor':
      $table = "doctreg";
      $id_column = "did";
      break;
    case 'patient':
      $table = "patreg";
      $id_column = "pid";
      break;
    default:
      $res = ["status" => "error", "message" => "Invalid role"];
      echo json_encode($res);
      exit;
  }

  $sql = "SELECT * FROM {$table} WHERE email = :email";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":email", $email, PDO::PARAM_STR);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    // User found, check password
    $user = $stmt->fetch();

    if (password_verify($password, $user["password"])) {
      session_regenerate_id();

      $_SESSION["is_logged_in"] = true;
      $_SESSION["role"] = $role;



      //$_SESSION[$id_column] = $user[$id_column];  
      // Set role-specific session variables
      if ($role === 'admin') {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
      } elseif ($role === 'doctor') {
        $_SESSION['doctor_id'] = $user['did'];
        $_SESSION['docfname'] = $user['docfname'];
        $_SESSION['doclname'] = $user['doclname'];
        $_SESSION['username'] = $user['docfname'] . " " . $user['doclname'];
      } elseif ($role === 'patient') {
        $_SESSION['patient_id'] = $user['pid'];
        $_SESSION['patfname'] = $user['patfname'];
        $_SESSION['patlname'] = $user['patlname'];
        $_SESSION['gender'] = $user['gender'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['contact'] = $user['contact'];
        $_SESSION['username'] = $user['patfname'] . " " . $user['patlname'];
      }


      // Update session ID dynamically in the database
      $session_id = session_id();
      $sql = "UPDATE {$table} SET {$session_column} = :session_id WHERE {$id_column} = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":session_id", $session_id, PDO::PARAM_STR);
      $stmt->bindParam(":id", $user[$id_column], PDO::PARAM_INT);
      $stmt->execute();

      $res = ["status" => "success", "message" => "Login successful"];
    } else {
      $res = ["status" => "error", "message" => "Invalid password"];
    }
  } else {
    $res = ["status" => "error", "message" => "No user found with this email"];
  }
  echo json_encode($res);

  // change password for all role
} elseif (isset($_POST["action"]) && $_POST['action'] === 'change_password') {
  if (!validateSession()) {
    $res = ["status" => "error", "message" => "Session expired. Please login again."];
    echo json_encode($res);
    exit();
  }

  $currentPassword = $_POST['currentPassword'];
  $newPassword = $_POST['newPassword'];
  $role = $_SESSION['role'];

  $table = "";
  $id_column = "";
  $userId = "";

  switch ($role) {
    case 'admin':
      $table = "user";
      $id_column = "id";
      $userId = $_SESSION['user_id'];
      break;
    case 'doctor':
      $table = "doctreg";
      $id_column = "did";
      $userId = $_SESSION['doctor_id'];
      break;
    case 'patient':
      $table = "patreg";
      $id_column = "pid";
      $userId = $_SESSION['patient_id'];
      break;
    default:
      echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
      exit();
  }

  try {
    $stmt = $conn->prepare("SELECT password FROM {$table} WHERE {$id_column} = :id");
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || !password_verify($currentPassword, $result['password'])) {
      echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
      exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE {$table} SET password = :password WHERE {$id_column} = :id");
    $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
      echo json_encode(['status' => 'success', 'message' => 'Password changed successfully']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to change password']);
    }
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
  }
} else {
  $res = ["status" => "error", "message" => "Invalid action"];
  echo json_encode($res);
}
