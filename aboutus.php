<?php
include_once('dbcon.php');

if (!validateSession()) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit();
}

include(__DIR__ . "/layout/header.php");
include(__DIR__ . "/layout/sidebar.php");
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">About Us - Global Hospital</h1>
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

              <!-- About Us Header Section -->
              <div class="header-section animate__animated animate__fadeIn">
                <h1>Welcome to Global Hospital</h1>
                <p>Your health is our priority</p>
              </div>

              <!-- About Us Description -->
              <div class="about-us-section animate__animated animate__fadeInUp">
                <h2>About Us</h2>
                <p>
                  Global Hospital is a world-class healthcare provider with a commitment to providing exceptional medical services to our patients. Our hospital is equipped with the latest medical technology, and our team of experienced doctors and healthcare professionals is dedicated to ensuring that you receive the best possible care.
                </p>
                <p>
                  Our vision is to provide quality healthcare to all, and our mission is to promote health, wellness, and healing through compassionate care. We focus on delivering personalized, patient-centered care to improve the overall well-being of our community.
                </p>
              </div>

              <!-- Services Section with Animation -->
              <div class="service-section animate__animated animate__fadeInUp">
                <h2>Our Services</h2>
                <div class="row">
                  <div class="col-md-4">
                    <div class="service-card">
                      <h3>General Medicine</h3>
                      <p>We provide comprehensive healthcare for all ages, including preventive care, diagnosis, and treatment of common illnesses.</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="service-card">
                      <h3>Surgery</h3>
                      <p>Our skilled surgeons perform a variety of surgeries with precision and care, ensuring your safety and comfort.</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="service-card">
                      <h3>Emergency Care</h3>
                      <p>We offer round-the-clock emergency care for critical situations, with fast response and expert medical attention.</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Meet Our Team Section -->
              <div class="team-section animate__animated animate__fadeInUp">
                <h2>Meet Our Team</h2>
                <div class="row">
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/ceo.jpeg" alt="Dr.Jay Goyani">
                      <h4>Mr. Jay Goyani</h4>
                      <p>Founder & CEO</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/co-founder.jpeg" alt="Dr. Emily Clark">
                      <h4>Mr. Ankur Timbadiya</h4>
                      <p>Co-Founder</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/doctor1.jpeg" alt="Dr. Jane Smith">
                      <h4>Dr. Jane Smith</h4>
                      <p>Surgeon</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/doctor4.jpeg" alt="Dr. Emily Clark">
                      <h4>Dr. Emily Clark</h4>
                      <p>Cardiologist</p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/doctor3.jpeg" alt="Dr. Michael Brown">
                      <h4>Dr. Michael Brown</h4>
                      <p>Pediatrician</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/doctor4.jpeg" alt="Dr. Sarah Johnson">
                      <h4>Dr. Sarah Johnson</h4>
                      <p>Orthopedic Surgeon</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/doctor6.jpeg" alt="Dr. Robert Wilson">
                      <h4>Dr. Robert Wilson</h4>
                      <p>Neurologist</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-card">
                      <img src="dist/img/doctor5.jpeg" alt="Dr. Jessica Davis">
                      <h4>Dr. Jessica Davis</h4>
                      <p>General Surgeon</p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Contact Us Section -->
          <div class="contact-section animate__animated animate__fadeInUp">
            <h2>Contact Us</h2>
            <p>If you have any questions or need further assistance, feel free to reach out to us. Our team is here to help you!</p>
            <a href="contactUs.php">Contact Us</a>
          </div>

      </div><!-- /.card-body -->
    </div>
  </section>
</div>
</div>
</section>
</div>

<?php
include(__DIR__ . "/layout/footer.php");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elements = document.querySelectorAll('.animate__animated');
    elements.forEach(function(element) {
      element.classList.add('animate__delay-1s');
    });
  });
</script>

<style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
  }

  .header-section {
    background-color: #007bff;
    color: white;
    padding: 50px 0;
    text-align: center;
    margin-bottom: 30px;
    animation: fadeIn 2s;
  }

  .header-section h1 {
    font-size: 3rem;
  }

  .header-section p {
    font-size: 1.25rem;
  }

  .about-us-section,
  .service-section,
  .team-section,
  .contact-section {
    padding: 60px 0;
    text-align: center;
    animation: fadeInUp 2s;
  }

  .about-us-section h2,
  .service-section h2,
  .team-section h2,
  .contact-section h2 {
    color: #007bff;
    margin-bottom: 20px;
  }

  .service-card,
  .team-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    text-align: center;
    margin-bottom: 30px;
    background-color: #f9f9f9;
    transition: transform 0.3s;
  }

  .service-card:hover,
  .team-card:hover {
    transform: scale(1.05);
  }

  .service-card h3,
  .team-card h4 {
    color: #007bff;
  }

  .team-card img {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin-bottom: 20px;
  }

  .contact-section a {
    font-size: 1.2rem;
    color: #007bff;
    text-decoration: none;
    border: 2px solid #007bff;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
  }

  .contact-section a:hover {
    background-color: #007bff;
    color: white;
  }
</style>