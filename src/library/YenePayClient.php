<?php
// namespace YenePayClient;
// use Requests;
// use YenePayClient\BearerTokenAuth;
require_once (__DIR__ . "/../vendor/rmccue/requests/library/Requests.php");
require_once (__DIR__ . "/BearerTokenAuth.php");
require_once (__DIR__ . '/Models/SendMoneyRequest.php');
require_once (__DIR__ . '/Models/MoneyRecipient.php');
require_once (__DIR__ . '/Config/YenePaySettings.php');
require_once (__DIR__ . '/Models/SendMoneyResponse.php');
class YenePayClient {
    const API_BASE_URL = "https://endpont.yenepay.com/api/client/send";
    // const API_BASE_URL = "https://host.docker.internal:44327/api/client/send";
    private $settings;
    
    public function __construct(YenePaySettings $settings) {
        $this->settings = $settings;
    }

    public function sendMoney($request){
        $json = json_encode($request);
        $headers = array('Content-Type' => 'application/json');
        $options = array(
            'auth' => new BearerTokenAuth($this->settings->getToken()),
            'verify' => false,
            'timeout' => 30
        );
         try{
			Requests::register_autoloader();
			$response = Requests::post(self::API_BASE_URL, $headers, $json, $options);
            // return $json;
            return new SendMoneyResponse($response);
		 }
		catch(Exception $ex)
		{
			return new SendMoneyResponse($ex->getMessage());
		}
    }

    public function createSignedRequest($msgToRecipients, $recipients){
        $request = new SendMoneyRequest();
        $request->setRecipients($recipients);
        $request->setMsgToRecipients($msgToRecipients);
        
        $this->signData($request);
        return $request;
    }

    private function signData(&$request) {
        $recArrays = array();
        foreach ($request->getRecipients() as $rec) {
            $recArrays[$rec->getCustomerCode()] = $rec;
        }
        ksort($recArrays);
        $recKeyValues = array();
        foreach ($recArrays as $rec) {
            $recKeyValues[] = $rec->getCustomerCode() . '=' . number_format($rec->getAmount(), 2, ".", "");
        }
        $sigArray = array(
            "ReceiverCode=" . implode(",", $recKeyValues),
            "Amount=" . number_format($request->getTotalPayment(), 2, ".", ""),
            "Code=" . $this->settings->getMerchantCode(),
            "Currency=" . $request->getCurrency()
        );
        $sigData = implode("&", $sigArray);
        // $pkey = openssl_pkey_get_private($this->settings->getSigningKey());
        $pkey = $this->settings->getSigningKey();
        
        $signature = '';
         openssl_sign($sigData, $signature, $pkey, OPENSSL_ALGO_SHA256);
        // openssl_free_key($pkey);
        $request->setPayerSignature(base64_encode($signature));
    }
}
?>