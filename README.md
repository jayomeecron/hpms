# Hospital Patient Management System (HPMS) Documentation

## Overview
The Hospital Patient Management System (HPMS) is a comprehensive web-based application designed to manage hospital operations, patient records, appointments, and prescriptions. The system serves three types of users: Patients, Doctors, and Administrators.

## System Architecture
- Backend: PHP
- Database: MySQL
- Frontend: HTML5, CSS3, JavaScript, jQuery
- UI Framework: Bootstrap, AdminLTE
- Session Management: PHP Sessions

## Directory Structure
```
/hpms/
├── admin/              # Administrator module
├── auth/               # Authentication module
├── doctor/             # Doctor module
├── patient/            # Patient module
├── layout/             # Common layout files
└── assets/             # Static resources
```

## Core Modules

### 1. Authentication Module (/auth/)
- Login System (login.php)
- Registration System (register.php)
- Password Management (change_password.php)
- Session Management (backend.php)
- Logout Functionality (logout.php)

### 2. Patient Module (/patient/)
- Appointment Booking (appointment.php)
- Appointment History (appointment_history.php)
- Prescription View (pat_prescription.php)

### 3. Doctor Module (/doctor/)
- Appointment Management (doc_appointment.php)
- Prescription Management (doc_prescription.php)
- Patient Records (docpresctb.php)

### 4. Admin Module (/admin/)
- Doctor Management (doctor_list.php, add_doctor.php)
- Patient Management (patient_list.php)
- Appointment Overview (adminappointment_details.php)
- Message Management (messages.php)

## Key Features

### Authentication & Security
- Secure login/registration system
- Password hashing
- Session management
- Role-based access control

### Patient Features
- Book appointments with doctors
- View appointment history
- Access prescriptions
- Update profile information

### Doctor Features
- Manage patient appointments
- Create and manage prescriptions
- View patient history
- Schedule management

### Admin Features
- Add/manage doctors
- View patient records
- Monitor appointments
- System message management

### General Features
- Responsive design
- User-friendly interface
- Contact form
- About us page

## Database Structure
The system uses MySQL database with the following key tables:
- user (Admin information)
- doctreg (Doctor registration)
- patreg (Patient registration)
- appointment (Appointment records)
- prescription (Medical prescriptions)

## Security Features
1. Password Hashing
2. Session Management
3. SQL Injection Prevention
4. XSS Protection
5. CSRF Protection

## Contact Information
For technical support or queries, please use the contact form available on the website.

## System Requirements
- Web Server: Apache/Nginx
- PHP Version: 7.4 or higher
- MySQL Version: 5.7 or higher
- Modern web browser with JavaScript enabled

## Installation Guide
1. Clone the repository to your web server directory
2. Import the database schema
3. Configure database credentials in constants.php
4. Ensure proper file permissions
5. Access the system through web browser

## Maintenance
Regular maintenance tasks include:
- Database backup
- Log file management
- Security updates
- Performance optimization
