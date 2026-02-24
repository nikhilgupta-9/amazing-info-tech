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
// Fetch products under the specified subcategory using `sub_category_id`
$sub_cat_query = "SELECT * FROM `cat_prod` WHERE sub_category_id = '$subcategory_id' AND status = '1'";
$sub_cat_result = mysqli_query($conn, $sub_cat_query);
?>

<?php 

echo '<pre>';
print_r($_POST);
echo '</pre>';

// payaction
    $payaction  = $_POST['payaction']??'';
    if($payaction && $payaction='buy_product'){
        


$apiKey = '44ce7708-239a-488a-9ee5-50d1945aaa26';
$merchantId = 'M22VCV02JBS4Q';

$paymentData = array(
    'merchantId' => $merchantId,
    'merchantTransactionId' => "'.$.'",
    "merchantUserId"=>"'.$' ",
    'amount' => $price*100, 
    'redirectUrl'=>"https://webhook.site/redirect-url",
    'redirectMode'=>"POST",
    'callbackUrl'=>"https://webhook.site/redirect-url",
    "merchantOrderId"=> "YOUR_ORDER_ID",
   "mobileNumber"=>"CUSTMER_MOBILE_NUMBER",
   "message"=>"Order description",
     "shortName"=>"CUSTMER_Name",
   "paymentInstrument"=> array(    
    "type"=> "PAY_PAGE",
  )
);



$jsonencode = json_encode($paymentData);
 $payloadMain = base64_encode($jsonencode);


$salt_index = 1; //key index 1
$payload = $payloadMain . "/pg/v1/pay" . $apiKey;
$sha256 = hash("sha256", $payload);
$final_x_header = $sha256 . '###' . $salt_index;
$request = json_encode(array('request'=>$payloadMain));






$merchantId = 'M22VCV02JBS4Q'; 
$apiKey="44ce7708-239a-488a-9ee5-50d1945aaa26";
$redirectUrl = 'payment-success.php';

$order_id = uniqid(); 
$name="Tutorials Website";
$email="info@tutorialswebsite.com";
$mobile=9999999999;
$amount = 10;
$description = 'thank you ';


// $paymentData = array(
//     'merchantId' => $merchantId,
//     'merchantTransactionId' => "MT7850590068188104",
//     "merchantUserId"=>"MUID123",
//     'amount' => $amount*100,
//     'redirectUrl'=>$redirectUrl,
//     'redirectMode'=>"POST",
//     'callbackUrl'=>$redirectUrl,
//     "merchantOrderId"=>$order_id,
//   "mobileNumber"=>$mobile,
//   "message"=>$description,
//   "email"=>$email,
//   "shortName"=>$name,
//   "paymentInstrument"=> array(    
//     "type"=> "PAY_PAGE",
//   )
// );


 $jsonencode = json_encode($paymentData);
 $payloadMain = base64_encode($jsonencode);
 $salt_index = 1; //key index 1
 $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
 $sha256 = hash("sha256", $payload);
 $final_x_header = $sha256 . '###' . $salt_index;
 $request = json_encode(array('request'=>$payloadMain));
 
   $base = base64_encode($enc);
        $hash = hash('sha256', $base."/pg/v1/paybdfd094b-5cf4-4d16-b337-fbb06ca127e5");               
$curl = curl_init();
curl_setopt_array($curl,


[
  CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
   CURLOPT_POSTFIELDS => '{"request":"'.$base.'"}',
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
     "X-VERIFY: ".$hash. $final_x_header,
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
 
if(isset($res->success) && $res->success=='1'){
$paymentCode=$res->code;
$paymentMsg=$res->message;
$payUrl=$res->data->instrumentResponse->redirectInfo->url;

header('Location:'.$payUrl) ;
}

}       

}


?>
