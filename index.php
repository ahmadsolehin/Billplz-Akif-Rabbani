<?php

require_once('billplz_api.php');


define('BILLPLZ_COLLECTION_ID', 'collection');
define('BILLPLZ_API', '73eb57f0-7d4e-42b9-a544-aeac6e4b0f81');

$billplz = new BillplzApiv3(BILLPLZ_API);

// create bill
$bill_created = $billplz->create_bill($collection_id, $amount, $title, $name, $email, $phone, $redirect_url, $callback_url);

if ($bill_created) {
    // bill created
}

// check bill (call on callback url)
$status = $billplz->get_bill($purchase_data['bill_id']);
if ($status->paid == true) {

    // update paid.

}










?>