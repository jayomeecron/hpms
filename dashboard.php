<?php

require_once('dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

// Get statistics for admin dashboard
function getAdminStats() {
  global $conn;
  $stats = [];
  
  try {
    // Total Patients
    $stmt = $conn->query("SELECT COUNT(*) FROM patreg");
    $stats['total_patients'] = $stmt->fetchColumn();
    
    // Total Doctors
    $stmt = $conn->query("SELECT COUNT(*) FROM doctreg");
    $stats['total_doctors'] = $stmt->fetchColumn();
    
    // Total Appointments
    $stmt = $conn->query("SELECT COUNT(*) FROM appointmenttb");
    $stats['total_appointments'] = $stmt->fetchColumn();
    
    // Today's Appointments
    $stmt = $conn->query("SELECT COUNT(*) FROM appointmenttb WHERE DATE(appdate) = CURDATE()");
    $stats['today_appointments'] = $stmt->fetchColumn();
  } catch (PDOException $e) {
    error_log("Error in getAdminStats: " . $e->getMessage());
    $stats = [
      'total_patients' => 0,
      'total_doctors' => 0,
      'total_appointments' => 0,
      'today_appointments' => 0
    ];
  }
  
  return $stats;
}

// Get recent appointments
function getRecentAppointments() {
  global $conn;
  try {
    $stmt = $conn->query("SELECT 
                          a.*,
                          CONCAT(a.patfname, ' ', a.patlname) as patient_name,
                          CONCAT(a.docfname, ' ', a.doclname) as doctor_name,
                          a.appdate as appointment_date,
                          a.userStatus as status
                        FROM appointmenttb a 
                        ORDER BY a.appdate DESC, a.apptime DESC 
                        LIMIT 5");
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    error_log("Error in getRecentAppointments: " . $e->getMessage());
    return [];
  }
}

include(__DIR__ . "/layout/header.php");
include(__DIR__ . "/layout/sidebar.php");

// Get stats if admin
$adminStats = [];
$recentAppointments = [];
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
  $adminStats = getAdminStats();
  $recentAppointments = getRecentAppointments();
}
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Dashboard</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
        <!-- Admin Dashboard -->
        <div class="row">
          <!-- Total Patients -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $adminStats['total_patients']; ?></h3>
                <p>Total Patients</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="<?= ADMIN_URL ?>/patient_list.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          
          <!-- Total Doctors -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $adminStats['total_doctors']; ?></h3>
                <p>Total Doctors</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-md"></i>
              </div>
              <a href="<?= ADMIN_URL ?>/doctor_list.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          
          <!-- Total Appointments -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $adminStats['total_appointments']; ?></h3>
                <p>Total Appointments</p>
              </div>
              <div class="icon">
                <i class="fas fa-calendar-check"></i>
              </div>
              <a href="<?= ADMIN_URL ?>/adminappointment_details.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          
          <!-- Today's Appointments -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $adminStats['today_appointments']; ?></h3>
                <p>Today's Appointments</p>
              </div>
              <div class="icon">
                <i class="fas fa-clock"></i>
              </div>
              <a href="<?= ADMIN_URL ?>/adminappointment_details.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-rocket mr-1"></i>
                  Quick Actions
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <a href="<?= ADMIN_URL ?>/add_doctor.php" class="btn btn-primary btn-block mb-3">
                      <i class="fas fa-user-md mr-2"></i> Add New Doctor
                    </a>
                  </div>
                  <div class="col-md-3">
                    <a href="<?= ADMIN_URL ?>/adminappointment_details.php" class="btn btn-info btn-block mb-3">
                      <i class="fas fa-calendar-plus mr-2"></i> View Appointments
                    </a>
                  </div>
                  <div class="col-md-3">
                    <a href="<?= ADMIN_URL ?>/messages.php" class="btn btn-warning btn-block mb-3">
                      <i class="fas fa-envelope mr-2"></i> Check Messages
                    </a>
                  </div>
                  <div class="col-md-3">
                    <a href="<?= ADMIN_URL ?>/patient_list.php" class="btn btn-success btn-block mb-3">
                      <i class="fas fa-users mr-2"></i> View Patients
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Appointments -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-calendar-check mr-1"></i>
                  Recent Appointments
                </h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Patient</th>
                      <th>Doctor</th>
                      <th>Date & Time</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($recentAppointments as $apt) { ?>
                      <tr>
                        <td><?php echo htmlspecialchars($apt['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($apt['doctor_name']); ?></td>
                        <td>
                          <?php 
                            echo date('M d, Y', strtotime($apt['appointment_date'])) . ' at ' . 
                                 date('h:i A', strtotime($apt['apptime'])); 
                          ?>
                        </td>
                        <td>
                          <?php 
                            $statusClass = '';
                            $statusText = '';
                            
                            if ($apt['userStatus'] == 1 && $apt['doctorStatus'] == 1) {
                              $statusClass = 'success';
                              $statusText = 'Confirmed';
                            } elseif ($apt['userStatus'] == 0 || $apt['doctorStatus'] == 0) {
                              $statusClass = 'danger';
                              $statusText = 'Cancelled';
                            } else {
                              $statusClass = 'warning';
                              $statusText = 'Pending';
                            }
                          ?>
                          <span class="badge badge-<?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                          </span>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      <?php } elseif ($_SESSION['role'] == 'patient') { ?>
        <!-- Patient Dashboard -->
        <p>Here, you can manage your appointments and view your medical history.</p>
        <div id="calendar"></div>
      <?php } elseif ($_SESSION['role'] == 'doctor') { ?>
        <!-- Doctor Dashboard -->
        <p>Here, you can manage patient appointments and view your schedule.</p>
        <div id="calendar"></div>
      <?php } ?>
    </div>
  </section>
</div>

<?php include(__DIR__ . "/layout/footer.php"); ?>

<!-- Calendar Scripts -->
<?php if ($_SESSION['role'] != 'admin') { ?>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
  $(document).ready(function() {
    var calendar = new FullCalendar.Calendar($('#calendar')[0], {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialView: 'dayGridMonth',
      events: function(fetchInfo, successCallback, failureCallback) {
        var data = {};

        if ('<?php echo $_SESSION['role']; ?>' === 'patient') {
          data = {
            pid: '<?php echo $_SESSION['patient_id']; ?>'
          };
        } else if ('<?php echo $_SESSION['role']; ?>' === 'doctor') {
          data = {
            did: '<?php echo $_SESSION['doctor_id']; ?>'
          };
        }

        $.ajax({
          url: 'fetch_appointments.php',
          type: 'POST',
          data: data,
          dataType: 'json',
          success: function(response) {
            successCallback(response);
          },
          error: function() {
            alert("Failed to load events!");
            failureCallback([]);
          }
        });
      },
      eventClick: function(info) {
        alert("Appointment ID: " + info.event.extendedProps.aptid + "\nAppointment Details:\n" + info.event.title);
      }
    });

    calendar.render();
  });
</script>
<?php } ?>