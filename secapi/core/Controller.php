<?php

namespace secapi\core;

class Controller
{

    function __construct()
    {

        $this->receiveData();

        /*
        TODO:
        1. function send data
        1.1 generate password
        1.2 crypt data by AES and password
        1.3 crypt password by public_key
        1.4 send data and password to server
        */

        /*
        TODO:
        1. function receive data
        1.1 decrypt password
        1.2 decrypt data by AES and password
        */

        header('Content-type: application/json');

    }

    function sendData() {

    }

    function receiveData() {
        $rawData = file_get_contents("php://input");
        $this->data = json_decode($rawData);
    }

    function decryptData() {
    }

    function encryptData() {

        $password = $this->data->password;
        $body = $this->data->body;

        $privateKey = $_SESSION['server_private_key'];

        $rsa = new \Crypt_RSA();
        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        $rsa->loadKey($privateKey, CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
        $s = new \Math_BigInteger($password, 16);
        $pwd_decrypt = $rsa->decrypt($s->toBytes());

    }

}