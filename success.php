<?php
$transid = isset($_GET['transid']) ? htmlspecialchars($_GET['transid']) : '';

if ($transid) {
    echo "<h1>Payment Successful!</h1>";
    echo "<p>Your transaction ID is: <strong>$transid</strong></p>";
} else {
    echo "<h1>Payment Confirmation</h1>";
    echo "<p>Transaction ID not available.</p>";
}
?>
