<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$param = array();

$param['extra_input'] = $_POST;
$param['extra_input']['payment_method'] = 'paytm';
unset($_POST);

$PG_TXNID = $OrderId = '';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1/api_liteStore/post.php/pg/response");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

$server_output = json_decode($server_output, true);

$OrderId = (isset($server_output['data']['OrderId'])? $server_output['data']['OrderId']:'');
$PG_TXNID = (isset($server_output['data']['PG_TXNID'])? $server_output['data']['PG_TXNID']:'');

if ($OrderId && $PG_TXNID) {
	//header("Location: http://127.0.0.1/liteStoreClient/order-success/".$PG_TXNID); // for build version
	header("Location: http://127.0.0.1:4201/order-success/".$PG_TXNID);
    exit;
} else {
	//header("Location: http://127.0.0.1/liteStoreClient/order-fail"); // for build version
	header("Location: http://127.0.0.1:4201/order-fail");
    exit;
}

?>