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
    const API_BASE_URL = "http://host.docker.internal:5281/api/client/send";
    const TOKEN = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjA4NTMzNmFmZTY0Yzg2ZWQ3NDU5YzE5YzQ4ZjQzNzI3IiwidHlwIjoiYXQrand0In0.eyJuYmYiOjE2MjkzMjk5MTMsImV4cCI6MTY5MjQwMTkxMywiaXNzIjoiaHR0cHM6Ly9ob3N0LmRvY2tlci5pbnRlcm5hbDo0NDMxMCIsImF1ZCI6WyJodHRwczovL2hvc3QuZG9ja2VyLmludGVybmFsOjQ0MzEwL3Jlc291cmNlcyIsIkJ1c2luZXNzQXBpQWNjZXNzIl0sImNsaWVudF9pZCI6IllQTUNMXzczNTRfYWJkMGI1YmItNDc4Yy00MmIzLWE1MzgtODE1MzliOWZlOWQ3IiwiY2xpZW50X3VzZXJfaWQiOiI2NjBhZjVmYS05NzJjLTRmZTAtYWZhYS0wNzM0ZjRmNzk3Y2UiLCJjbGllbnRfY3VzdG9tZXJfaWQiOiIzN2IyMGRlMS01ZTFmLTQ0M2YtYjU3NS0zZWE3OWRjMWI5ZjIiLCJqdGkiOiI4c3hzdGtIcWFjRFk1ei1fUmVmMnRnIiwic2NvcGUiOlsiQnVzaW5lc3NBcGlBY2Nlc3MiXX0.hT6zR79zIdjet26GQfCr5d_3AR2ym_PHvwtOOXKJOLwq5YoYI7QrN8gLfuLNl_oesKRUVCUxDG0q0-7U735fCSfjcZrwkhNLfEUDl31O0RzAWXVJp-xAsmoRgRLbmAC8JY8_LtG08xv0QNbCmh3vyTPYZQT8LO8ap0N_fvi8Kire-cCUqgiillv-PAIn5Ac49FcZDHr5EFAP2LAl4Kwe64vwgQcFdJVjOJD1kBnY-lYYCas8JEVm_xu-QrQ1UP9rvkAAA-AOAQtCzKlQBdhdQ5YpXFURrgPv5BRdly5rCojIIwGWDNDeFyvLcn4ETrvj3TWjdcaBsl1vQsY67qZbHg";
    const PRIVATE_KEY = "https://host.docker.internal:44327";
    const CUSTOMER_CODE = "https://host.docker.internal:44327";
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