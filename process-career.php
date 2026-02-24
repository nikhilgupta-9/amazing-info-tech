
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/jquery-3.7.1.min.js"></script>

<?php

include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $applyFor = $_POST['apply_for'];
    $resume = $_FILES['file'];

    // File upload path
    $uploadDir = 'admin/uploads/resumes/';
    $uploadFile = $uploadDir . basename($resume['name']);

    // Save the uploaded file
    if (move_uploaded_file($resume['tmp_name'], $uploadFile)) {
        // Email configuration
        $to = "ksuraj.2me@gmail.com"; // HR email
        $subject = "New Career Application: $name";
        $message = "
            <h2>Career Application</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Mobile No:</strong> $number</p>
            <p><strong>Apply For:</strong> $applyFor</p>
        ";
        $headers = "From: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Attachment
        $content = chunk_split(base64_encode(file_get_contents($uploadFile)));
        $uid = md5(uniqid(time()));
        $filename = basename($resume['name']);

        // Boundary 
        $boundary = "----=" . md5(uniqid(time()));
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";
        $messageBody = "--$boundary\r\n";
        $messageBody .= "Content-Type: text/html; charset=UTF-8\r\n";
        $messageBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $messageBody .= $message . "\r\n";
        $messageBody .= "--$boundary\r\n";
        $messageBody .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
        $messageBody .= "Content-Transfer-Encoding: base64\r\n";
        $messageBody .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
        $messageBody .= $content . "\r\n";
        $messageBody .= "--$boundary--";

        // Send email
        if (mail($to, $subject, $messageBody, $headers)) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Application Submitted',
                        text: 'Your application has been submitted successfully!',
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: 'There was an issue submitting your application.',
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'File Upload Failed',
                    text: 'There was an error uploading your resume.',
                });
              </script>";
    }
}
?>


<!-- Place the SweetAlert2 script just before the closing </body> tag -->


</body>
</html>
