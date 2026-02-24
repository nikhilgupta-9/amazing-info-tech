<?php include("conn.php");

$query = "SELECT * FROM users WHERE id='1'";
if ($sql_query = $conn->query($query)) {
  if ($sql_query->num_rows > 0) {
    $result = $sql_query->fetch_array(MYSQLI_ASSOC);
    $name = $result['name'];
    $company_name = $result['company_name'];
    $email = $result['email'];
    $enquiry_email = $result['enquiry_email'];
    $mobile = $result['mobile'];
    $whatsapp_number = $result['whatsapp_number'];
    $customer_support_number = $result['customer_support_number'];
    $paytm_number = $result['paytm_number'];
    $paytm_file = $result['paytm_file'];
    $fax_number = $result['fax_number'];
    $working_hours = $result['working_hours'];
    $working_hours1 = $result['working_hours1'];
    $working_hours2 = $result['working_hours2'];
    $working_hours3 = $result['working_hours3'];
    $working_hours4 = $result['working_hours4'];
    $working_hours5 = $result['working_hours5'];
    $address = $result['address'];
    $state = $result['state'];
    $city = $result['city'];
    $pin_code = $result['pin_code'];
    $head_office = $result['head_office'];
    $office_number = $result['office_number'];
    $google_map = $result['google_map'];
    $country = $result['country'];
    $website = $result['website'];
    $catalog_url = $result['catalog_url'];
    $skype_link = $result['skype_link'];
    $facebook_link = $result['facebook_link'];
    $twittter_link = $result['twittter_link'];
    $linkedin_link = $result['linkedin_link'];
    $instagram_link = $result['instagram_link'];
    $youtube_link = $result['youtube_link'];
    $pinterest_link = $result['pinterest_link'];
    $others_link = $result['others_link'];
    $visitor_vounter_code = $result['visitor_vounter_code'];
    $language_converter_code = $result['language_converter_code'];
    $blog_url = $result['blog_url'];
    $designed_dev = $result['designed_dev'];
    $copyright = $result['copyright'];
    $domain_name = $result['domain_name'];
    $out_going_server = $result['out_going_server'];
    $server_email = $result['server_email'];
    $server_email_password = $result['server_email_password'];
  }
}

// Fetch branches for the table
$branches = [];
$result = $conn->query("SELECT * FROM `branches`");
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $branches[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content>
  <meta name="keywords" content>
  <title>Amazing Infotech Pvt. Ltd.</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
  <link rel="stylesheet" href="assets/css/flaticon.css">
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  
  <!-- Load jQuery and SweetAlert -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="home-3">
  <?php include('header.php') ?>

  <main class="main">
    <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
      <div class="container">
        <h2 class="breadcrumb-title">Contact us</h2>
        <ul class="breadcrumb-menu">
          <li><a href="<?= $site ?>index.php">Home</a></li>
          <li class="active">Contact us</li>
        </ul>
      </div>
    </div>

    <div class="contact-area py-50">
      <div class="container">
        <div class="contact-wrap">
          <div class="row">
            <div class="col-lg-5">
              <div class="contact-content">
                <div class="contact-info">
                  <div class="contact-info-icon">
                    <i class="fal fa-location-dot"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Head Office Address</h5>
                    <p><?= $address ?></p>
                  </div>
                </div>
                <div class="contact-info">
                  <div class="contact-info-icon">
                    <i class="fal fa-phone-volume"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Call Us</h5>
                    <p>+91 <?= $mobile ?>, <?= $customer_support_number ?></p>
                  </div>
                </div>
                <div class="contact-info">
                  <div class="contact-info-icon">
                    <i class="fal fa-envelope"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Email Us</h5>
                    <p><a href="mailto:<?= $email ?>"> <?= $email ?>,<br> <?= $enquiry_email ?></a></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="contact-form">
                <div class="contact-form-header">
                  <h2>Get In Touch</h2>
                </div>
                <form method="post" id="contact-form">
                  <!-- Honeypot field (hidden) -->
                  <input type="text" name="website" style="display: none;">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Your Name" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Mobile No." required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Your Subject" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Write Your Message" required></textarea>
                  </div>
                  
                  <!-- Submit button with ID -->
                  <button type="submit" class="theme-btn" id="submit-btn" name="submit">Send Message <i class="far fa-paper-plane"></i></button>
                  
                  <div class="col-md-12 mt-3">
                    <!-- Fixed ID for response -->
                    <div id="form-response" class="form-messege"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14008.142956740205!2d77.2918317664655!3d28.628690945084937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce4b2f79b09d5%3A0x158880a7f1a9f5c4!2sI.P.Extension%2C%20Patparganj%2C%20Delhi!5e0!3m2!1sen!2sin!4v1729141530344!5m2!1sen!2sin"
          width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>

      </div>
    </div>

    <div class="blog-single-area pt-50 pb-50">
      <div class="container">
        <h3 class="pb-3"> Branch Offices</h3>
        <div class="row">
          <?php foreach ($branches as $branch): ?>
          <div class="col-md-6 col-12">
            <div class="branches-box">
              <h3><?php echo htmlspecialchars($branch['name']); ?></h3>
              <p><b>Address:-</b> <?php echo htmlspecialchars($branch['address']); ?></p>
              <p><b>Contact Person:-</b> <?php echo htmlspecialchars($branch['contact_person']); ?></p>
              <p><b>Mobile No-</b> <a href="tel:<?php echo htmlspecialchars($branch['moblie_no']); ?>">+91-<?php echo htmlspecialchars($branch['moblie_no']); ?></a></p>
            </div>
          </div>  
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </main>
  
  <?php include('footer.php') ?>
  
  <!-- AJAX Script -->
  <script>
  $(document).ready(function() {
      $('#contact-form').on('submit', function(e) {
          e.preventDefault();
          
          // Disable submit button and show loading state
          var submitBtn = $('#submit-btn');
          var originalText = submitBtn.html();
          submitBtn.prop('disabled', true).html('Submitting... <i class="far fa-spinner fa-spin"></i>');
          
          // Clear previous messages
          $('#form-response').removeClass('text-success text-danger').html('');
          
          // Get form data
          var formData = {
              fname: $('#fname').val(),
              email: $('#email').val(),
              phone: $('#phone').val(),
              subject: $('#subject').val(),
              message: $('#message').val(),
              website: $('input[name="website"]').val() // honeypot
          };
          
          // Validate required fields
          if (!formData.fname || !formData.email || !formData.phone || !formData.message) {
              $('#form-response').addClass('text-danger').html('Please fill all required fields.');
              submitBtn.prop('disabled', false).html(originalText);
              return false;
          }
          
          // Email validation
          var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailPattern.test(formData.email)) {
              $('#form-response').addClass('text-danger').html('Please enter a valid email address.');
              submitBtn.prop('disabled', false).html(originalText);
              return false;
          }
          
          // Phone validation (simple)
          var phonePattern = /^[0-9]{10,15}$/;
          var phoneDigits = formData.phone.replace(/\D/g, '');
          if (!phonePattern.test(phoneDigits)) {
              $('#form-response').addClass('text-danger').html('Please enter a valid phone number (10-15 digits).');
              submitBtn.prop('disabled', false).html(originalText);
              return false;
          }
          
          // Send AJAX request
          $.ajax({
              url: 'send_mail.php',
              type: 'POST',
              data: formData,
              dataType: 'json',
              success: function(response) {
                  if (response.status === 'success') {
                      // Show success message
                      $('#form-response').addClass('text-success').html(response.message);
                      
                      // Reset form
                      $('#contact-form')[0].reset();
                      
                      // Show SweetAlert with contact ID
                      var alertMessage = response.message;
                      if (response.contact_id) {
                          alertMessage += ' (Reference ID: #' + response.contact_id + ')';
                      }
                      
                      Swal.fire({
                          icon: 'success',
                          title: 'Success!',
                          text: alertMessage,
                          timer: 4000,
                          showConfirmButton: true
                      });
                  } else {
                      // Show error message
                      $('#form-response').addClass('text-danger').html(response.message);
                      
                      // Show SweetAlert for error
                      Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: response.message
                      });
                  }
              },
              error: function(xhr, status, error) {
                  $('#form-response').addClass('text-danger').html('An error occurred. Please try again.');
                  
                  Swal.fire({
                      icon: 'error',
                      title: 'Network Error!',
                      text: 'Please check your connection and try again.'
                  });
              },
              complete: function() {
                  submitBtn.prop('disabled', false).html(originalText);
              }
          });
      });
  });
  </script>
</body>
</html>