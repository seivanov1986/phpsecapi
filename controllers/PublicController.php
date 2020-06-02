<?php

namespace controllers;

use secapi\core\Controller;

class PublicController extends Controller
{

    function actionTest() {

        $this->encryptData();

        $server_private_key = $_SESSION['server_private_key'];
        $server_public_key = $_SESSION['server_public_key'];
        $user_public_key = $_SESSION['user_public_key'];

        echo json_encode([
            'server_public_key' => $server_public_key,
            'server_private_key' => $server_private_key,
            'user_public_key' => $user_public_key
        ]);

    }

    function actionHandshake() {

        define('CRYPT_RSA_MODE', CRYPT_RSA_MODE_INTERNAL);
        $rsa = new \Crypt_RSA();
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_RAW);
        $key = $rsa->createKey(512);
        $e = new \Math_BigInteger($key['publickey']['e'], 10);
        $n = new \Math_BigInteger($key['publickey']['n'], 10);
        $pubkey = $n->toHex();
        $pubkey2 = $e->toHex();

        $keyPair = openssl_pkey_new(array(
            "private_key_bits" => 1024,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        ));
        $server_private_key = null;
        openssl_pkey_export($keyPair, $server_private_key);

        $keyDetails = openssl_pkey_get_details($keyPair);
        $server_public_key = $keyDetails['key'];

        $_SESSION['server_private_key'] = $key['privatekey'];
        $_SESSION['server_public_key'] = $server_public_key;
        $_SESSION['user_public_key'] = $this->data->public_key;

        echo json_encode([
            'server_public_key' => $pubkey,
            'server_public_key_2' => $pubkey2,
            'server_private_key' => $key['privatekey'],
            'user_public_key' => $this->data->public_key
        ]);

    }

}