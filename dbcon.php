  <?php

require_once 'constants.php';

// Database connection options
$dboptions = array(
  PDO::ATTR_PERSISTENT => FALSE,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
);

// Establishing the database connection from constants.php file
try {
  $conn = new PDO(DB_DRIVER . ':host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD, $dboptions);
} catch (Exception $ex) {
  echo $ex->getMessage();
  die;
}

// Start the session if it hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
  // Starts the session only if it hasn't been started yet
  session_start([
    'use_strict_mode' => true, // Ensures a new session ID is created if the session is invalid
    'cookie_httponly' => true, // Prevents JavaScript access to session cookies
    'cookie_secure' => isset($_SERVER['HTTPS']), // Use secure cookies if HTTPS is enabled
    'cookie_samesite' => 'Strict', // Prevent CSRF attacks
  ]);
}

include_once "dbHelper.php";

function validateUserRole($id, $column, $table)
{
  global $conn;
  $sql = "SELECT session_id FROM {$table} WHERE {$column} = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->execute();
  $storedSessionId = $stmt->fetchColumn();
  return $storedSessionId === session_id();
}

function validateSession()
{
  if (empty($_SESSION["is_logged_in"])) {
    return false;
  }

  $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
  if (!$role) {
    return false;
  }

  switch ($role) {
    case 'admin':
      return validateUserRole($_SESSION['user_id'], 'id', 'user');
    case 'doctor':
      return validateUserRole($_SESSION['doctor_id'], 'did', 'doctreg');
    case 'patient':
      return validateUserRole($_SESSION['patient_id'], 'pid', 'patreg');
    default:
      return false;
  }
}
