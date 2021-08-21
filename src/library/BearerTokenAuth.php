<?php
// namespace YenePayClient;

require_once (__DIR__ . "/../vendor/rmccue/requests/library/Requests/Auth.php");
// require_once (__DIR__ . "/../vendor/rmccue/requests/library/Requests/Hooks.php");
// require_once (__DIR__ . "/../vendor/rmccue/requests/library/Requests/Hooker.php");

class BearerTokenAuth implements Requests_Auth {
    protected $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function register(Requests_Hooks $hooks) {
        $hooks->register('requests.before_request', array($this, 'before_request'));
    }

    public function before_request(&$url, &$headers, &$data, &$type, &$options) {
        $headers['Authorization'] = 'Bearer ' . $this->token;
    }
}
?>
