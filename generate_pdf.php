<?php
require_once('vendor/autoload.php');

class CustomPDF extends TCPDF {
    public function Header() {
        // Logo
        $this->Image('assets/img/logo.png', 15, 10, 30);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(0, 15, 'Hospital Patient Management System', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // Line
        $this->Line(15, 25, 195, 25);
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Line
        $this->Line(15, 282, 195, 282);
        // Footer text
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().' | Global Hospital HPMS Documentation | '.date('Y'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Global Hospital');
$pdf->SetAuthor('Global Hospital IT Team');
$pdf->SetTitle('Hospital Patient Management System - Technical Documentation');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// Set margins
$pdf->SetMargins(15, 30, 15);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 25);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set default font subsetting mode
$pdf->setFontSubsetting(true);

// Add cover page
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 30);
$pdf->Cell(0, 50, '', 0, 1);
$pdf->Cell(0, 15, 'Hospital Patient', 0, 1, 'C');
$pdf->Cell(0, 15, 'Management System', 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 15, 'Technical Documentation', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Version 1.0', 0, 1, 'C');
$pdf->Cell(0, 10, 'Global Hospital', 0, 1, 'C');
$pdf->Cell(0, 10, date('F Y'), 0, 1, 'C');

// Add table of contents page
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 15, 'Table of Contents', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// Content with better styling
$content = <<<EOD
<style>
    h1 { 
        font-size: 24pt; 
        color: #2C3E50; 
        background-color: #ECF0F1; 
        padding: 10px; 
        margin-top: 20px; 
        margin-bottom: 10px; 
        border-left: 8px solid #3498DB;
    }
    h2 { 
        font-size: 18pt; 
        color: #34495E; 
        border-bottom: 3px solid #BDC3C7; 
        padding-bottom: 5px; 
        margin-top: 15px; 
        margin-bottom: 10px;
    }
    h3 {
        font-size: 14pt;
        color: #2980B9;
        margin-top: 10px;
        margin-bottom: 5px;
    }
    .table-header {
        background-color: #2C3E50;
        color: #FFFFFF;
        padding: 10px;
        font-weight: bold;
        font-size: 12pt;
    }
    .table-row-odd {
        background-color: #F8F9F9;
        padding: 8px;
    }
    .table-row-even {
        background-color: #FFFFFF;
        padding: 8px;
    }
    .important-note {
        background-color: #FFF3CD;
        padding: 15px;
        margin: 15px 0;
        border-left: 5px solid #FFA500;
        font-style: italic;
    }
    .warning {
        background-color: #FFE6E6;
        padding: 15px;
        margin: 15px 0;
        border-left: 5px solid #FF0000;
    }
    .success {
        background-color: #E6FFE6;
        padding: 15px;
        margin: 15px 0;
        border-left: 5px solid #00FF00;
    }
    .feature-list {
        margin: 10px 0 10px 20px;
        line-height: 1.6;
    }
    .section-break {
        border-top: 2px dashed #BDC3C7;
        margin: 20px 0;
    }
    p {
        text-align: justify;
        line-height: 1.6;
    }
</style>

<h1>1. Document Information</h1>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td width="30%">Document Detail</td>
        <td width="70%">Value</td>
    </tr>
    <tr class="table-row-odd">
        <td>Document Title</td>
        <td>Hospital Patient Management System - Technical Documentation</td>
    </tr>
    <tr class="table-row-even">
        <td>Version</td>
        <td>1.0</td>
    </tr>
    <tr class="table-row-odd">
        <td>Release Date</td>
        <td>January 2025</td>
    </tr>
    <tr class="table-row-even">
        <td>Last Updated</td>
        <td>January 9, 2025</td>
    </tr>
    <tr class="table-row-odd">
        <td>Document Owner</td>
        <td>Global Hospital IT Team</td>
    </tr>
</table>

<div class="section-break"></div>

<h1>2. System Overview</h1>
<h2>2.1 Introduction</h2>
<p>
The Hospital Patient Management System (HPMS) is a comprehensive healthcare information management solution designed to streamline hospital operations, enhance patient care, and improve administrative efficiency. This system integrates various aspects of hospital management into a unified, secure, and user-friendly platform.
</p>

<h2>2.2 Purpose and Objectives</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td width="30%">Objective</td>
        <td width="70%">Description</td>
    </tr>
    <tr class="table-row-odd">
        <td>Patient Care Enhancement</td>
        <td>Improve patient care through better information management and accessibility</td>
    </tr>
    <tr class="table-row-even">
        <td>Operational Efficiency</td>
        <td>Streamline hospital operations and reduce administrative overhead</td>
    </tr>
    <tr class="table-row-odd">
        <td>Data Management</td>
        <td>Centralize and secure medical records and patient information</td>
    </tr>
    <tr class="table-row-even">
        <td>Communication</td>
        <td>Enhance communication between patients, doctors, and staff</td>
    </tr>
</table>

<h2>2.3 Target Users</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>User Type</td>
        <td>Access Level</td>
        <td>Primary Functions</td>
    </tr>
    <tr class="table-row-odd">
        <td>Administrators</td>
        <td>Full System Access</td>
        <td>System management, user management, reporting</td>
    </tr>
    <tr class="table-row-even">
        <td>Doctors</td>
        <td>Clinical Access</td>
        <td>Patient records, appointments, prescriptions</td>
    </tr>
    <tr class="table-row-odd">
        <td>Patients</td>
        <td>Limited Access</td>
        <td>Appointments, medical records, prescriptions</td>
    </tr>
</table>

<div class="section-break"></div>

<h1>3. Technical Architecture</h1>

<h2>3.1 Technology Stack</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>Layer</td>
        <td>Technology</td>
        <td>Version</td>
        <td>Purpose</td>
    </tr>
    <tr class="table-row-odd">
        <td>Frontend</td>
        <td>HTML5, CSS3, JavaScript</td>
        <td>Latest</td>
        <td>User interface and client-side functionality</td>
    </tr>
    <tr class="table-row-even">
        <td>UI Framework</td>
        <td>Bootstrap, AdminLTE</td>
        <td>5.x, 3.x</td>
        <td>Responsive design and admin interface</td>
    </tr>
    <tr class="table-row-odd">
        <td>Backend</td>
        <td>PHP</td>
        <td>7.4+</td>
        <td>Server-side processing</td>
    </tr>
    <tr class="table-row-even">
        <td>Database</td>
        <td>MySQL</td>
        <td>5.7+</td>
        <td>Data storage and management</td>
    </tr>
    <tr class="table-row-odd">
        <td>Web Server</td>
        <td>Apache/Nginx</td>
        <td>Latest</td>
        <td>HTTP server and request handling</td>
    </tr>
</table>

<h2>3.2 System Architecture Diagram</h2>
<div class="important-note">
The system follows a three-tier architecture:
• Presentation Layer (Frontend)
• Application Layer (Backend)
• Data Layer (Database)
</div>

<h2>3.3 Database Schema</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>Table Name</td>
        <td>Primary Key</td>
        <td>Key Fields</td>
        <td>Description</td>
    </tr>
    <tr class="table-row-odd">
        <td>user</td>
        <td>id</td>
        <td>username, email, password</td>
        <td>Admin user information</td>
    </tr>
    <tr class="table-row-even">
        <td>doctreg</td>
        <td>did</td>
        <td>docfname, doclname, spec</td>
        <td>Doctor registration details</td>
    </tr>
    <tr class="table-row-odd">
        <td>patreg</td>
        <td>pid</td>
        <td>patfname, patlname, contact</td>
        <td>Patient registration records</td>
    </tr>
    <tr class="table-row-even">
        <td>appointment</td>
        <td>id</td>
        <td>doctor_id, patient_id, date</td>
        <td>Appointment records</td>
    </tr>
</table>

<div class="section-break"></div>

<h1>4. Core Functionalities</h1>

<h2>4.1 User Authentication</h2>
<div class="feature-list">
• Secure login system<br>
• Role-based access control<br>
• Password encryption<br>
• Session management<br>
• Password reset functionality
</div>

<h2>4.2 Patient Management</h2>
<div class="feature-list">
• Patient registration<br>
• Medical history tracking<br>
• Appointment scheduling<br>
• Prescription access<br>
• Profile management
</div>

<h2>4.3 Doctor Management</h2>
<div class="feature-list">
• Doctor registration<br>
• Schedule management<br>
• Patient record access<br>
• Prescription management<br>
• Appointment overview
</div>

<div class="section-break"></div>

<h1>5. Security Implementation</h1>

<h2>5.1 Authentication Security</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>Feature</td>
        <td>Implementation</td>
        <td>Purpose</td>
    </tr>
    <tr class="table-row-odd">
        <td>Password Hashing</td>
        <td>PHP password_hash()</td>
        <td>Secure password storage</td>
    </tr>
    <tr class="table-row-even">
        <td>Session Management</td>
        <td>PHP Sessions</td>
        <td>User session handling</td>
    </tr>
    <tr class="table-row-odd">
        <td>SQL Injection Prevention</td>
        <td>PDO Prepared Statements</td>
        <td>Database query security</td>
    </tr>
</table>

<div class="warning">
<b>Security Warning:</b> Regular security audits and updates are mandatory to maintain system security.
</div>

<div class="section-break"></div>

<h1>6. Installation Guide</h1>

<h2>6.1 System Requirements</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>Component</td>
        <td>Minimum Requirement</td>
        <td>Recommended</td>
    </tr>
    <tr class="table-row-odd">
        <td>Processor</td>
        <td>2.0 GHz Dual Core</td>
        <td>2.4 GHz Quad Core</td>
    </tr>
    <tr class="table-row-even">
        <td>RAM</td>
        <td>4 GB</td>
        <td>8 GB</td>
    </tr>
    <tr class="table-row-odd">
        <td>Storage</td>
        <td>20 GB</td>
        <td>50 GB SSD</td>
    </tr>
    <tr class="table-row-even">
        <td>Network</td>
        <td>10 Mbps</td>
        <td>100 Mbps</td>
    </tr>
</table>

<h2>6.2 Installation Steps</h2>
<div class="feature-list">
1. Clone repository from source control<br>
2. Install required dependencies<br>
3. Configure database settings<br>
4. Set up web server<br>
5. Initialize the system<br>
6. Create admin account
</div>

<div class="success">
<b>Installation Note:</b> Follow the steps in sequence to ensure proper system setup.
</div>

<div class="section-break"></div>

<h1>7. Maintenance and Support</h1>

<h2>7.1 Routine Maintenance</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>Task</td>
        <td>Frequency</td>
        <td>Description</td>
    </tr>
    <tr class="table-row-odd">
        <td>Database Backup</td>
        <td>Daily</td>
        <td>Full backup of all databases</td>
    </tr>
    <tr class="table-row-even">
        <td>Log Rotation</td>
        <td>Weekly</td>
        <td>System log management</td>
    </tr>
    <tr class="table-row-odd">
        <td>Security Updates</td>
        <td>Monthly</td>
        <td>System security patches</td>
    </tr>
</table>

<h2>7.2 Support Channels</h2>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="table-header">
        <td>Channel</td>
        <td>Contact Details</td>
        <td>Availability</td>
    </tr>
    <tr class="table-row-odd">
        <td>Technical Support</td>
        <td>support@globalhospital.com</td>
        <td>24/7</td>
    </tr>
    <tr class="table-row-even">
        <td>Emergency Support</td>
        <td>emergency@globalhospital.com</td>
        <td>24/7</td>
    </tr>
</table>

EOD;

// Print content
$pdf->writeHTML($content, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('/var/www/html/hpms/HPMS_Documentation.pdf', 'F');
?>
