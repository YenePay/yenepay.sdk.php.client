<?php
class MoneyRecipient implements JsonSerializable {
    private $customerCode;
    private $email;
    private $amount;

    function __construct()
	{
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
	}

    function __construct3($customerCode, $email, $amount)
	{
		$this->customerCode = $customerCode;
		$this->email = $email;
		$this->amount = $amount;
	}
    /**
     * Customer Code of the item.
     *
     * @param string $customerCode
     *
     * @return $this
     */
    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;
        return $this;
    }

    /**
     * Customer Code of the item.
     *
     * @return string
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * Email or Phone of the item.
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Email or Phone of the item.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Amount of the item.
     *
     * @param string $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Email or Phone of the item.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    public function jsonSerialize() {
        return [
            'customerCode' => $this->customerCode,
            'email' => $this->email,
            'amount' => $this->amount
        ];
    }
}
?>