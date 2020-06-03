<?php

namespace secapi\core;

/**
 * Class Controller
 * @package secapi\core
 */
class Controller
{

    /**
     * Controller constructor.
     */
    function __construct()
    {

        $this->receiveData();
        header('Content-type: application/json');

    }

    /**
     *
     */
    function sendData()
    {

    }

    /**
     *
     */
    function receiveData()
    {

        $rawData = file_get_contents("php://input");
        $this->data = json_decode($rawData);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->data = new \StdClass();
        }

    }

    /**
     *
     */
    function decryptData()
    {
    }

    /**
     *
     */
    function encryptData()
    {

        $password = $this->data->password;
        $body = $this->data->body;

        $privateKey = $_SESSION['server_private_key'];

        $rsa = new \Crypt_RSA();
        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        $rsa->loadKey($privateKey, CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
        $s = new \Math_BigInteger($password, 16);
        $pwd_decrypt = $rsa->decrypt($s->toBytes());

        $iv = 'a1a2a3a4a5a6a7a8b1b2b3b4b5b6b7b8';
        $key = hash('sha256', $pwd_decrypt);

        $ivBytes = hex2bin($iv);
        $keyBytes = hex2bin($key);
        $ctBytes = base64_decode($body);

        $decrypt = openssl_decrypt($ctBytes, "aes-256-cbc", $keyBytes, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $ivBytes);

    }

}