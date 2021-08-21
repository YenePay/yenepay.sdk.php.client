<?php
// use YenePayClient\YenePayClient;
require_once (__DIR__ . '/library/YenePayClient.php');
require_once (__DIR__ . '/library/Models/SendMoneyRequest.php');
require_once (__DIR__ . '/library/Models/MoneyRecipient.php');

$request = new SendMoneyRequest();
// $request->setCustomerCode('0325');
$recipients = array(
    new MoneyRecipient('9358', '+251911000011', 100)
);
$request->setRecipients($recipients);
$request->setMsgToRecipients('Send Money Test');

$client = new YenePayClient();
$response = $client->sendMoney($request);
var_dump($response);
?>