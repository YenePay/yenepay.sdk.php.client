<?php
require_once (__DIR__ . '/TransactionModel.php');
require_once (__DIR__ . '/MoneyRecipient.php');
class SendMoneyResponse implements JsonSerializable {
    private $duplicateRecipients = array();
    private $nonExistingRecipients = array();
    private $codeMismatchRecipients = array();
    private $isError = true;
    private $errorMessage;
    private $httpStatusCode;
    private $successResult;
    private $isPaymentCompleted = false;
    private $shouldContinueManually = false;
    private $manualContinueUrl;

    public function __construct($response){
        if(is_null($response)){
            $this->initError("Uknown error occured", 0);
        } elseif(is_string($response)){
            $this->initError("Uknown error occured", 0);
        } elseif($response->status_code == 200){
            $this->parseBody(json_decode($response->body));
        } else {
            $this->initError($response->body, $response->status_code);
        }
    }

    private function initError($error, $httpStatusCode){
        $this->isError = true;
        $this->errorMessage = $error;
        $this->httpStatusCode = $httpStatusCode;
    }

    private function parseBody($body){
        $validationErr = $this->checkValidation($body);
        if(!is_null($validationErr)){
            $this->initError($validationErr, 200);
            return;
        }
        $order = new TransactionModel($body->{'order'});
        $this->successResult = $order;
        $this->isPaymentCompleted = $order->getIsPaymentCompleted();
        if(!$this->isPaymentCompleted){
            $this->shouldContinueManually = true;
            $this->manualContinueUrl = "https://yenepay.com/checkout/home/continue/" . $order->getOrderId();
        }
        $this->isError = false;
        $this->httpStatusCode = 200;
    }

    private function checkValidation($body){
        // var_dump($body);
        if ($body->{'isOrderValid'} == false)
            {
                return "Send money request validation failed";
            }
            if ($body->{'isCommissionPaymentCorrect'} == false)
            {
                return "Commision amount validation failed";
            }
            if ($body->{'isTotalPaymentCorrect'} == false)
            {
                return "Total amount is not correct";
            }
            if (is_array($body->{'duplicatedRecipients'}) && count($body->{'duplicatedRecipients'}) > 0)
            {
                $this->duplicateRecipients = $this->toRecipientArray($body->{'duplicatedRecipients'});
                return "Found some duplicate recipients";
            }
            if (is_array($body->{'nonExistingRecipients'}) && count($body->{'nonExistingRecipients'}) > 0)
            {
                $this->nonExistingRecipients = $this->toRecipientArray($body->{'nonExistingRecipients'});
                return "Could not find some recipients";
            }
            if (is_array($body->{'email_CodeMismatches'}) && count($body->{'email_CodeMismatches'}) > 0)
            {
                $this->codeMismatchRecipients = $this->toRecipientArray($body->{'email_CodeMismatches'});
                return "Found some recipients whose email/phone does not match with the supplied customer code";
            }
            return null;
    }

    public function getDuplicateRecipients() {
        return $this->duplicateRecipients;
    }
    public function getNonExistingRecipients() {
        return $this->nonExistingRecipients;
    }
    public function getCodeMismatchRecipients() {
        return $this->codeMismatchRecipients;
    }
    public function getIsError() {
        return $this->isError;
    }
    public function getErrorMessage() {
        return $this->errorMessage;
    }
    public function getHttpStatusCode() {
        return $this->httpStatusCode;
    }
    public function getSuccessResult() {
        return $this->successResult;
    }
    public function getIsPaymentCompleted() {
        return $this->isPaymentCompleted;
    }
    public function getShouldContinueManually() {
        return $this->shouldContinueManually;
    }
    public function getManualContinueUrl() {
        return $this->manualContinueUrl;
    }

    private function toRecipientArray($recipients){
        $recArrays = array();
        foreach ($recipients as $rec) {
            $recArrays[] = new MoneyRecipient($rec->{'customerCode'}, $rec->{'amount'});
        }
        return $recArrays;
    }

    public function jsonSerialize() {
        return [
            'duplicateRecipients' => $this->duplicateRecipients,
            'nonExistingRecipients' => $this->nonExistingRecipients,
            'codeMismatchRecipients' => $this->codeMismatchRecipients,
            'isError' => $this->isError,
            'errorMessage' => $this->errorMessage,
            'httpStatusCode' => $this->httpStatusCode,
            'successResult' => $this->successResult,
            'isPaymentCompleted' => $this->isPaymentCompleted,
            'shouldContinueManually' => $this->continueManually,
            'manualContinueUrl' => $this->manualContinueUrl,
        ];
    }
}
?>