<?php
require "conn.php";
require "webwila-phone-pe-config.php";

function ww_save_trnx_details($conn, $dataToUpdate, $pay_hash)
{
    $sql = "UPDATE payments SET payment_response='" . $dataToUpdate['payment_response'] . "', payment_status=" . $dataToUpdate['payment_status'] . ",payment_id='" . $dataToUpdate['payment_id'] . "', updated_at='" . date("Y-m-d H:i:s") . "' WHERE pay_hash='{$pay_hash}'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}


$postData = $_POST;
$paymentMode = $_REQUEST['mode'];
try {
    // if mode is phonepe
    if ($paymentMode == "phonepe") {
        $pg_status = $postData['code']; // PAYMENT_SUCCESS
        $merchantId = $postData['merchantId'];
        $merchantTransactionId = $postData['transactionId'];
        $amount = $postData['amount'];
        $checksum = $postData['checksum'];


        // get payment data from local db
//    $query = "SELECT * FROM payments WHERE pay_hash = '$merchantTransactionId' LIMIT 1";
        $query = "SELECT * FROM payments WHERE pay_hash = '$merchantTransactionId' AND payment_status=0 LIMIT 1";
        $trnxDataQuery = mysqli_query($conn, $query);
        $trnxData = array();
        if (mysqli_num_rows($trnxDataQuery) > 0) {
            $trnxData = mysqli_fetch_assoc($trnxDataQuery);
        }
        // if product data is not found
        if (empty($trnxData)) {
            throw new Exception("Invalid request. System transactionId details not found.");
        }
        // end trnx data

        // Cross verify amount
        if (($trnxData['amount'] * 100) != $postData['amount']) {
            throw new Exception("Invalid request. Amount mismatch.");
        }


//    echo '<pre>';
//    print_r($postData);
//    print_r($trnxData);
//    echo '</pre>';
//    die();


        $phonePePaymentsClient = ww_get_phonePeClientInstance();
        $checkStatus = $phonePePaymentsClient->statusCheck($merchantTransactionId);
        // Check transactionId with old id and amount as well
        $responseCode = $checkStatus->getResponseCode();
        $state = $checkStatus->getState();

        $dataToUpdate = array();
        $dataToUpdate['payment_response'] = json_encode($postData);
        $dataToUpdate['payment_status'] = 0;
        $dataToUpdate['payment_id'] = $checkStatus->getTransactionId();

        // if payment id done
        if ($state === "COMPLETED" && $responseCode === "SUCCESS") {
            // update status of local db
//            $sql = "UPDATE payments SET payment_response='" . json_encode($postData) . "', payment_status=1,payment_id='" . $checkStatus->getTransactionId() . "', updated_at='" . date("Y-m-d H:i:s") . "' WHERE pay_hash='{$merchantTransactionId}'";
            $dataToUpdate['payment_status'] = 1;
            $trnxUpdated = ww_save_trnx_details($conn, $dataToUpdate, $merchantTransactionId);
            if ($trnxUpdated) {
                ?>
                <script>
                    alert("Payment has been successfully completed.");
                    setTimeout(function () {
                        window.location.href = "<?php echo SITE_URL?>";
                    });
                </script>
                <?php
            } else {
                throw new Exception("Error updating record: " . $conn->error);
            }
            exit();
        } else {
            $dataToUpdate['payment_status'] = 0;
            $trnxUpdated = ww_save_trnx_details($conn, $dataToUpdate, $merchantTransactionId);
            throw new Exception("We could not able to process payment with this merchant transaction id $merchantTransactionId. Contact to website backend team.");
        }
    }
} catch (Exception $exception) {
    echo $exception->getMessage() . " <a target='_blank' href='" . SITE_URL . "'>Back to home</a>";
    die();
}