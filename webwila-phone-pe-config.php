<?php
include_once "conn.php";
require "vendor/autoload.php";


//const WW_PHONEPE_MERCHANTID = "AMAZINGUAT";
//const WW_PHONEPE_SALTKEY = "d745c8af-62b4-4d31-b52c-2e1043685e86";


// live keys
$ww_merchant_id = "M22VCV02JBS4Q";
$ww_salt_key = "44ce7708-239a-488a-9ee5-50d1945aaa26";
// live keys end

// Testing keys
if (ww_is_local_host()) {
    $ww_merchant_id = "AMAZINGUAT";
    $ww_salt_key = "d745c8af-62b4-4d31-b52c-2e1043685e86";
    define("WW_PHONEPE_ENV", \PhonePe\Env::UAT);
} else {
    define("WW_PHONEPE_ENV", \PhonePe\Env::PRODUCTION);
}


define("WW_PHONEPE_MERCHANTID", $ww_merchant_id);
define("WW_PHONEPE_SALTKEY", $ww_salt_key);

const WW_PHONEPE_SALTINDEX = 1;
const WW_PHONEPE_SHOLDPUBLISHEVENTS = false;

/**
 * @return \PhonePe\payments\v1\PhonePePaymentClient
 * ww_get_phonePeClientInstance
 * Return instance of phonepe̵
 */
function ww_get_phonePeClientInstance()
{
    return new \PhonePe\payments\v1\PhonePePaymentClient(WW_PHONEPE_MERCHANTID, WW_PHONEPE_SALTKEY, WW_PHONEPE_SALTINDEX, WW_PHONEPE_ENV, WW_PHONEPE_SHOLDPUBLISHEVENTS);
}