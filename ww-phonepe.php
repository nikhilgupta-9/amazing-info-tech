<?php
require 'conn.php';
require "webwila-phone-pe-config.php";

$formData = $_POST;
$payaction = $formData['payaction'] ?? '';
$product_id = $formData['product_id'] ?? false;

if (empty($payaction) || $payaction != "buy_product" || !$product_id) {
    header("Location: " . SITE_URL);
}

$query = "SELECT * FROM cat_prod WHERE id = '$product_id' AND status = '1' LIMIT 1";
$header = mysqli_query($conn, $query);

$productData = array();
if (mysqli_num_rows($header) > 0) {
    $productData = mysqli_fetch_assoc($header);
}
// if product data is not found
if (empty($productData)) {
    header("Location: " . SITE_URL);
    exit();
}

$productAmount = $productData['cat_pd_price'] ?? 0;

// $productAmount=1;


// validate price
if (!$productAmount) {
    header("Location: " . SITE_URL);
    exit();
}


$current_user_id = "GUEST" . time();

// Prepare Payment data
$paymentData = array();
$paymentData['merchantUserId'] = $current_user_id;
$paymentData['merchantTransactionId'] = "PAYHASH" . time();
$paymentData['amount'] = $productAmount * 100;

// init tnx
$trnxData = array();
$trnxData['is_guest'] = 1;
$trnxData['ip'] = ww_get_client_ip();
$trnxData['amount'] = $productAmount;
$trnxData['payment_method'] = "phonepe";
$trnxData['created_at'] = date("Y-m-d H:i:s");
$trnxData['updated_at'] = date("Y-m-d H:i:s");
$cart_data = array();
$cartItems = array(
    array(
        'item_title' => $productData['ct_pd_title'],
        'product_id' => $product_id,
        "amount" => $productAmount,
    )
);
$cart_data['cart_items'] = $cartItems;
$cart_data['payment_data'] = $paymentData;
$trnxData['cart_data'] = json_encode($cart_data);


// Construct SQL Query
// Construct SQL query dynamically
$sql = "INSERT INTO payments (is_guest, pay_hash ,ip, amount, payment_method, created_at, updated_at, cart_data) 
        VALUES (
            {$trnxData['is_guest']}, 
            '{$paymentData['merchantTransactionId']}', 
            '{$trnxData['ip']}', 
            {$trnxData['amount']}, 
            '{$trnxData['payment_method']}', 
            '{$trnxData['created_at']}', 
            '{$trnxData['updated_at']}', 
            '{$trnxData['cart_data']}'
        )";


$payment_id = false;
// Execute the query
if ($conn->query($sql) === TRUE) {
    $payment_id = $conn->insert_id; // Get the last inserted ID
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    die();
}
// Close connection
$conn->close();

/**
 * Prepare request
 */
$callbackURL = SITE_URL . 'ww-payment-callback.php?mode=phonepe';
// before process save data in trnx

try {
    $phonePePaymentsClient = ww_get_phonePeClientInstance();
    $request = \PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder::builder()
//        ->mobileNumber($paymentData['mobileNumber'])
        ->callbackUrl($callbackURL)
        ->merchantId(WW_PHONEPE_MERCHANTID)
        ->merchantUserId($paymentData['merchantUserId'])
        ->amount($paymentData['amount'])
        ->merchantTransactionId($paymentData['merchantTransactionId'])
        ->redirectUrl($callbackURL . '&redirectUrl=1')
        ->redirectMode("POST")
        ->paymentInstrument(\PhonePe\payments\v1\models\request\builders\InstrumentBuilder::buildPayPageInstrument())
        ->build();
    $response = $phonePePaymentsClient->pay($request);
    $url = $response->getInstrumentResponse()->getRedirectInfo()->getUrl();
    header("Location: $url");
    exit();
} catch (Exception $exception) {
    echo $exception->getMessage();
    die();
}



