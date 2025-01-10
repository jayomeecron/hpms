<?php
require_once('../dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../layout/header.php");
include("../layout/sidebar.php");
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Visitor Messages</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM inquiry";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($inquiries as $inquiry) {
                    echo "<tr>";
                    echo "<td>" . $inquiry["username"] . "</td>";
                    echo "<td>" . $inquiry["email"] . "</td>";
                    echo "<td>" . $inquiry["contact"] . "</td>";
                    echo "<td>" . $inquiry["subject"] . "</td>";
                    echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#messageModal' . $inquiry['visitor_id'] . '">View</button></td>';
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<?php
include("../layout/footer.php");
?>

<!-- Modal for Message View -->
<?php foreach ($inquiries as $inquiry): ?>
  <div class="modal fade" id="messageModal<?php echo $inquiry['visitor_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel<?php echo $inquiry['visitor_id']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="messageModalLabel<?php echo $inquiry['visitor_id']; ?>">Message Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <p><strong>Username:</strong> <?php echo $inquiry['username']; ?></p>
            </div>
            <div class="col-12">
              <p><strong>Email:</strong> <?php echo $inquiry['email']; ?></p>
            </div>
            <div class="col-12">
              <p><strong>Contact:</strong> <?php echo $inquiry['contact']; ?></p>
            </div>
            <div class="col-12">
              <p><strong>Subject:</strong> <?php echo $inquiry['subject']; ?></p>
            </div>
            <div class="col-12">
              <p><strong>Message:</strong></p>
              <p><?php echo nl2br($inquiry['message']); ?></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>