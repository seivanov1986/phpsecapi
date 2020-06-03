<?php

namespace controllers;

use secapi\core\Controller;
use secapi\core\Crypt;

/**
 * Class PublicController
 * @package controllers
 */
class PublicController extends Controller
{

    /**
     *
     */
    function actionTest()
    {

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

    /**
     *
     */
    function actionHandshake()
    {

        $new_key = Crypt::genKey();

        $_SESSION['server_private_key'] = $new_key['private_key'];
        $_SESSION['server_public_key'] = json_encode($new_key['public_key']);
        $_SESSION['user_public_key'] = $this->data->public_key;

        echo json_encode([
            'server_public_key' => $new_key['public_key'][0],
            'server_public_key_2' => $new_key['public_key'][1],
            'server_private_key' => $new_key['private_key'],
            'user_public_key' => $this->data->public_key
        ]);

    }

}