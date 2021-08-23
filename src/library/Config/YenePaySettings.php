<?php

class YenePaySettings implements JsonSerializable {
    private $merchantCode;
    private $token;
    private $signingKey;
    

    public function __construct($merchantCode, $token, $signingKey) {
        $this->merchantCode = $merchantCode;
        $this->token = $token;
        $this->signingKey = $signingKey;
    }

    public function getMerchantCode() {
        return $this->merchantCode;
    }

    public function getToken() {
        return $this->token;
    }

    public function getSigningKey() {
        return $this->signingKey;
    }

    public function jsonSerialize() {
        return [
            'merchantCode' => $this->merchantCode,
            'token' => $this->token,
            'signingKey' => $this->signingKey
        ];
    }
    
}
?>