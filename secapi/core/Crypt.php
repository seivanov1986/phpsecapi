<?php

namespace secapi\core;

define('CRYPT_RSA_MODE', CRYPT_RSA_MODE_INTERNAL);

class Crypt
{

    static function genKey()
    {

        $result = [];

        $rsa = new \Crypt_RSA();
        $key = [];

        if (is_object($rsa)) {
            $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_RAW);
            $key = $rsa->createKey(512);
        }

        if (isset($key['publickey']['e']) && isset($key['publickey']['n'])) {
            $e = new \Math_BigInteger($key['publickey']['e'], 10);
            $n = new \Math_BigInteger($key['publickey']['n'], 10);
        }

        if (is_object($n) && is_object($e) && isset($key['privatekey'])) {
            $result = [
                'public_key' => [
                    $n->toHex(),
                    $e->toHex()
                ],
                'private_key' => $key['privatekey']
            ];
        }

        return $result;

    }

}