<?php
// send_mail.php - DATABASE INSERT ONLY

// Include database connection
include('conn.php');

// Set JSON header
header('Content-Type: application/json');

// Initialize response
$response = ['status' => 'error', 'message' => ''];

// Debug: Log received data
error_log("Received POST data: " . print_r($_POST, true));

// **Simple anti-spam: honeypot field check**
if (!empty($_POST['website'])) {
    $response['message'] = 'Spam detected.';
    echo json_encode($response);
    exit();
}

// Validate required fields
$required_fields = ['fname', 'email', 'phone', 'message'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $response['message'] = 'Please fill all required fields.';
        echo json_encode($response);
        exit();
    }
}

// Validate email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Please enter a valid email address.';
    echo json_encode($response);
    exit();
}

// Sanitize input
$name = mysqli_real_escape_string($conn, trim($_POST['fname']));
$email = mysqli_real_escape_string($conn, trim($_POST['email']));
$phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
$subject = isset($_POST['subject']) ? mysqli_real_escape_string($conn, trim($_POST['subject'])) : 'No Subject';
$message = mysqli_real_escape_string($conn, trim($_POST['message']));
$datetime = date('Y-m-d H:i:s');

// **Step 1: Insert into database**
try {
    // Check if table exists, create if not
    $table_check = $conn->query("SHOW TABLES LIKE 'tbl_contact'");
    if ($table_check->num_rows == 0) {
        // Create table if it doesn't exist
        $create_table = "CREATE TABLE IF NOT EXISTS `tbl_contact` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `phone` VARCHAR(20) NOT NULL,
            `subject` VARCHAR(200) DEFAULT NULL,
            `message` TEXT NOT NULL,
            `datetime` DATETIME NOT NULL,
            `status` ENUM('new','read','replied') DEFAULT 'new',
            `ip_address` VARCHAR(45) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        if (!$conn->query($create_table)) {
            throw new Exception("Failed to create table: " . $conn->error);
        }
    }
    
    // Get IP address
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    
    // Prepare SQL statement
    $sql = "INSERT INTO tbl_contact (name, email, phone, subject, message, datetime) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $datetime);
    
    if ($stmt->execute()) {
        $contact_id = $stmt->insert_id;
        
        // Success - data inserted into database
        $response['status'] = 'success';
        $response['message'] = 'Thank you! Your message has been submitted successfully. We will contact you soon.';
        $response['contact_id'] = $contact_id;
        
        // Log the submission
        $log_message = date('Y-m-d H:i:s') . " - Contact #{$contact_id}: {$name} <{$email}> - {$phone}\n";
        file_put_contents('contact_submissions.log', $log_message, FILE_APPEND);
        
    } else {
        throw new Exception("Database insert failed: " . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    
    // Log error
    $log_message = date('Y-m-d H:i:s') . " - Database Error: " . $e->getMessage() . "\n";
    file_put_contents('contact_errors.log', $log_message, FILE_APPEND);
}

// Close database connection
$conn->close();

// Return JSON response
echo json_encode($response);
exit();
?>