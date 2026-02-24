<?php
// Database connection
include("conn.php");

// Get POST data from PhonePe
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

$orderId = $data['transactionId'];
$status = $data['status'];
$paymentId = $data['paymentId'] ?? null;

// Update the product stock
if ($status === "SUCCESS") {
    $stmt = $conn->prepare("UPDATE cat_prod SET stock = stock - 1 WHERE id = ?");
    $stmt->bind_param("i", $productId); // Assuming you have the product ID in the callback
    $stmt->execute();

    echo "Payment successful!";
} else {
    echo "Payment failed or pending.";
}

$conn->close();
?>
