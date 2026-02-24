
<?php
include 'conn.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile_no = $conn->real_escape_string($_POST['number']);
    $apply_for = $conn->real_escape_string($_POST['apply_for']);
    $resume_path = '';

    // Handle resume upload
    if (!empty($_FILES['file']['name'])) {
        $target_dir = "resumes/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
        }
        $resume_path = $target_dir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $resume_path);
    }

    // Insert data into the database
    $sql = "INSERT INTO career_applications (name, email, mobile_no, apply_for, resume) 
            VALUES ('$name', '$email', '$mobile_no', '$apply_for', '$resume_path')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Your application has been submitted successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Infotech Pvt. Ltd.</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf__TwrAAAAALKz4Z0g7EYSkE297cwgS9z5L5Xn"></script>

</head>
<body class="home-3">
    <?php include('header.php')?>

    <main class="main">
        <div class="career-background">
            <div class="career-bg">
                <img src="assets/img/career-bg.jpg" class="img-fluid">
            </div>
        </div>

        <div class="contact-area py-120">
            <div class="container">
                <div class="contact-wrap">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <div class="contact-form career-opot-bg">
                                <div class="contact-form-header">
                                    <h2>Career Opportunities</h2>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data" id="contact-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email id</label>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile No.</label>
                                        <input type="number" class="form-control" name="number" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Apply For</label>
                                        <select class="form-control" name="apply_for" required>
                                            <option value="">--apply for--</option>
                                              <option value="CEO">CEO</option>
                                            <option value="Support Engineer">Support Engineer</option>
                                            <option value="BDM">BDM (Business Development Manager)</option>
                                            <option value="Backend">Backend</option>
                                            <option value="Field executive">Field Executive</option>
                                            <option value="Accountant">Accountant</option>
                                        </select>    
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Resume</label>
                                        <input type="file" class="form-control" name="file" accept=".pdf" required>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6Lf__TwrAAAAALKz4Z0g7EYSkE297cwgS9z5L5Xn"></div>

                                    <button type="submit" class="theme-btn mt-3">Submit <i class="far fa-paper-plane"></i></button>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-messege text-success"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include('footer.php')?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $applyFor = $_POST['apply_for'];
    $resume = $_FILES['file']['name'];
    $temp_name = $_FILES['file']['tmp_name'];
    $folder = "admin/uploads/resumes/" . $resume;

    // Upload the resume to the folder
    if (move_uploaded_file($temp_name, $folder)) {
        // Save form data to the database
        $sql = "INSERT INTO `career_applications`(`name`, `email`, `mobile_no`, `apply_for`, `resume`) 
                VALUES ('$name', '$email', '$number', '$applyFor', '$resume')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            // Prepare email content for the employer
            $to = "support@amazinginfotech.in";
            $subject = "Career Application from " . $name;
            $from = "no-reply@Amazing-Infotech-pvt-ltd.com";
            
            $boundary = md5(uniqid(time())); // Unique boundary

            // Headers for email
            $headers = "From: $from\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

            // Email body message for employer
            $body = "--$boundary\r\n";
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= "<html><body>";
            $body .= "<h2>Application from: " . $name . "</h2>";
            $body .= "<p><strong>Name:</strong> " . $name . "</p>";
            $body .= "<p><strong>Email:</strong> " . $email . "</p>";
            $body .= "<p><strong>Number:</strong> " . $number . "</p>";
            $body .= "<p><strong>Applying for:</strong> " . $applyFor . "</p>";
            $body .= "</body></html>\r\n";

            // Read the resume file content
            $file_content = file_get_contents($folder);
            $encoded_file = chunk_split(base64_encode($file_content));

            // Attachment
            $body .= "--$boundary\r\n";
            $body .= "Content-Type: application/octet-stream; name=\"$resume\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$resume\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= $encoded_file . "\r\n";
            $body .= "--$boundary--\r\n";

            // Send the email to the employer
            if (mail($to, $subject, $body, $headers)) {
                // Prepare thank-you email content for the candidate
                $thankYouSubject = "Thank You for Your Application";
                $thankYouBody = "<html><body>";
                $thankYouBody .= "<h2>Dear " . $name . ",</h2>";
                $thankYouBody .= "<p>Thank you for applying for the position of " . $applyFor . " at Amazing Infotech Pvt. Ltd. We appreciate your interest in joining our team.</p>";
                $thankYouBody .= "<p>We will review your application and get back to you shortly.</p>";
                $thankYouBody .= "<p>Best regards,<br>The Amazing Infotech Team</p>";
                $thankYouBody .= "</body></html>";

                // Headers for candidate's thank-you email
                $thankYouHeaders = "From: $from\r\n";
                $thankYouHeaders .= "MIME-Version: 1.0\r\n";
                $thankYouHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

                // Send thank-you email to the candidate
                mail($email, $thankYouSubject, $thankYouBody, $thankYouHeaders);

                // Success message
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Application Submitted Successfully",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "careers.php";
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Email Error!",
                        text: "Failed to send the application email. Please try again later.",
                        confirmButtonText: "OK"
                    });
                </script>';
            }
        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Database Error!",
                    text: "Failed to save the application. Please try again later.",
                    confirmButtonText: "OK"
                });
            </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Upload Error!",
                text: "Failed to upload resume. Please try again.",
                confirmButtonText: "OK"
            });
        </script>';
    }
}
?>
