# yenepay.sdk.php.client (Coming Soon)
YenePay Client PHP SDK for merchants to send money automatically from their balance.
## Installation

Step 1: Include yenepay/php-sdk in your composer.json file

```
{
  "require": {
    	"yenepay/php-sdk": "dev-master"
    }
}
``` 

Step 2: Run ```composer install --no-dev``` to download and install the latest version of yenepay/php-sdk. This will download and put the library inside the vendor folder.		

Step 3: Open your payment processor PHP class and import the SDK's helper class and namespaces.

```
require_once (__DIR__ . '/../library/YenePayClient.php');
    require_once (__DIR__ . '/../library/Models/MoneyRecipient.php');
    require_once (__DIR__ . '/../library/Config/YenePaySettings.php');
```
Note: depending on your directory structure, the path to the library directory may be slightly different.
## Pre-requisite

### Creating client token and signing key
If you don't have it already to create access token and signing key for your client app go to your yenepay account setting page https://www.yenepay.com/account/#/settings

Then create a new client by going to merchants apps menu. After you create a new client copy and save both the access token and the generated private key for that client.

NOTE: Becareful where you put your token and key since it is a highly sensitive information.

### Sending money
To send money you can use the following php code
```php

    //Get your access token from the enviroment
    $token = $_ENV['YenePayToken'];
    //Get your merchant code from the enviroment
    $merchantCode = $_ENV['YenePayMerchantCode'];
    //Get your request signing key from the enviroment
    $signingKey = $_ENV['YenePaySigningKey'];
    
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

    //Check if payment completed
    if($response->getIsPaymentCompleted()){
        //The payment is completed 
    }
```

The response object is an instance of a class [SendMoneyResponse.php](https://github.com/YenePay/yenepay.sdk.php.client/tree/master/src/library/Models/SendMoneyResponse.php)

### Example
You can find a working example in the example directory in this repository. Please look at [send_money.php](https://github.com/YenePay/yenepay.sdk.php.client/tree/master/src/example/send_money.php) to see how to send the request. The [send.php](https://github.com/YenePay/yenepay.sdk.php.client/tree/master/src/example/send.php) will show the parsed request and response in detail for debugging.

![YenePay Send Money Client](https://github.com/YenePay/yenepay.sdk.php.client/raw/master/example.png)

### More
For more information please visit
- https://yenepay.com
- https://yenepay.com/developer
- https://community.yenepay.com

