<?php
class SendMoneyRequest implements JsonSerializable {
    private $payerSignature;
    private $serviceProviderCode = "YP005";
    private $msgToRecipients;
    private $currency = "ETB";
    private $recipients;

    function __construct()
	{
		// $a = func_get_args(); 
        // $i = func_num_args(); 
        // if (method_exists($this,$f='__construct'.$i)) { 
        //     call_user_func_array(array($this,$f),$a); 
        // } 
	}

    public function setPayerSignature($payerSignature)
    {
        $this->payerSignature = $payerSignature;
        return $this;
    }
    public function getPayerSignature()
    {
        return $this->payerSignature;
    }
    public function getServiceProviderCode()
    {
        return $this->serviceProviderCode;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
    public function setMsgToRecipients($msgToRecipients)
    {
        $this->msgToRecipients = $msgToRecipients;
        return $this;
    }
    public function getMsgToRecipients()
    {
        return $this->msgToRecipients;
    }

    public function getTotalPayment()
    {
        if(!is_array($this->recipients))
        return 0;

        $sum = 0;
        foreach ($this->recipients as $rec) {
            $sum = $sum + $rec->getAmount();
        }
        return $sum;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
        return $this;
    }
    public function getRecipients()
    {
        return $this->recipients;
    }

    public function jsonSerialize() {
        return [
            'payerSignature' => $this->payerSignature,
            'serviceProviderCode' => $this->serviceProviderCode,
            'msgToRecipients' => $this->msgToRecipients,
            'currency' => $this->currency,
            'totalPayment' => $this->getTotalPayment(),
            'recipients' => $this->recipients,
        ];
    }
}
?>