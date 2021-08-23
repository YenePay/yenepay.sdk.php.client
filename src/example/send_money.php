<?php
    //Note this path might change depending on your project directory structure
    require_once (__DIR__ . '/../library/YenePayClient.php');
    require_once (__DIR__ . '/../library/Models/MoneyRecipient.php');
    require_once (__DIR__ . '/../library/Config/YenePaySettings.php');

    
    //If you don't have it already to create access token and signing key for your client 
    //app visit https://www.yenepay.com/account/#/settings

    //Get your access token from the enviroment
    $token = $_ENV['YenePayToken'];
    //Get your merchant code from the enviroment
    $merchantCode = $_ENV['YenePayMerchantCode'];
    //Get your request signing key from the enviroment
    $signingKey = $_ENV['YenePaySigningKey'];

    //Note becareful where you put your token and key 
    //since it is a highly sensitive information
    
    //Create new setting object
    $settings = new YenePaySettings($merchantCode, $token, $signingKey);

    //Create recipients array with customerCode, amount
    $recipients = array(
        new MoneyRecipient('9358', 8)
    );

    //Create YenePay client with the setting
    $client = new YenePayClient($settings);

    //Create a signed request with message to recipients
    $request = $client->createSignedRequest('Your bonus money', $recipients);

    //Send the money
    $response = $client->sendMoney($request);
?>