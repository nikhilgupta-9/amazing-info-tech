<?php

include("conn.php");

$url = mysqli_real_escape_string($conn, $_GET['alias']);

// Query to get the subcategory based on the `ct_pd_url`
$query = "SELECT * FROM cat_prod WHERE ct_pd_url = '$url' AND status = '1' LIMIT 1";
$header = mysqli_query($conn, $query);

if (mysqli_num_rows($header) > 0) {
    $header1 = mysqli_fetch_assoc($header);
    $subcategory_id = $header1['id']; // Get the subcategory ID
    $subcategory_name = $header1['ct_pd_name']; // Get the subcategory name
    $product_images = explode(",", $header1['cat_pd_image']); // Split image filenames
    $price = $header1['cat_pd_price'];
    $mrp =$header1['cat_pd_mrp'];
    $long_desc = $header1['long_description'];
    $short_desc = $header1['small_description'];
} 



$merchantId = 'M22VCV02JBS4Q'; // Replace with your actual Merchant ID
$apiKey = "44ce7708-239a-488a-9ee5-50d1945aaa26"; // Replace with your actual API key
$order_id = uniqid(); // Generate a unique order ID for each transaction
$name = $_POST['customer_name'] ?? 'John Doe'; // Customer's name
$email = $_POST['customer_email'] ?? 'example@example.com'; // Customer's email
$mobile = $_POST['customer_mobile'] ?? '9999999999'; // Customer's mobile number
$amount = $price * 100; // Convert price to paisa (PhonePe uses integer values for currency)
$description = 'Thank you for your purchase!'; // A short order description

$paymentData = array(
    'merchantId' => $merchantId,
    'merchantTransactionId' => $order_id,
    'merchantUserId' => $email, // User's email as identifier
    'amount' => $amount,
    'redirectUrl' => "https://yourwebsite.com/payment-success.php",
    'redirectMode' => "POST",
    'callbackUrl' => "https://yourwebsite.com/payment-callback.php",
    "merchantOrderId" => $order_id,
    "mobileNumber" => $mobile,
    "message" => $description,
    "shortName" => $name,
    "paymentInstrument" => array(    
        "type" => "PAY_PAGE",
    )
);

$jsonencode = json_encode($paymentData);
$payloadMain = base64_encode($jsonencode);
$salt_index = 1;
$payload = $payloadMain . "/pg/v1/pay" . $apiKey;
$sha256 = hash("sha256", $payload);
$final_x_header = $sha256 . '###' . $salt_index;
$request = json_encode(array('request' => $payloadMain));


?>

<?php

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay", // Use the correct endpoint
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $request,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-VERIFY: " . $final_x_header,
        "accept: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $res = json_decode($response);

    if (isset($res->success) && $res->success == '1') {
        $paymentCode = $res->code;
        $paymentMsg = $res->message;
        $payUrl = $res->data->instrumentResponse->redirectInfo->url;

        header('Location:' . $payUrl);
        exit();
    } else {
        echo "Payment initiation failed: " . $res->message;
    }
}

?>