<?php

class SecurityPassClass {

    private $cost = ["cost"=>14]; 
    private $password;
    private $hash = PASSWORD_DEFAULT;

    public function __construct($password){
        $this->password = $password;
    }
    public function hash() {
        return password_hash($this->password, $this->hash, $this->cost);
    }
    public function verify($hashBBDD) {
           
        return password_verify($this->password, $hashBBDD);
    }
}

?>