<?php

namespace App\LendAPI;

use App\LendAPI\Config;

class User
{
    private $userId;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $email;
    private $errorMsg;

    public function __construct($accessToken)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, Config::URL . '/user/info');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_POST, false);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['x-and-auth-token: ' . $accessToken]);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);

        $result = json_decode($buffer, true);

        if (!is_array($result)) {
            $this->errorMsg = "json decode error.";
        } else {
            $code = $result['code'];
            if (0 != $code) {
                if (is_array($result['response']))
                    $this->errorMsg = $result['response']['error_description'];
                else $this->errorMsg = $result['response'];
            } else {
                $userInfo = $result['response'];

                $this->userId      = $userInfo['userId'];
                $this->firstName   = $userInfo['firstName'];
                $this->lastName    = $userInfo['lastName'];
                $this->phoneNumber = $userInfo['phoneNumber'];
                $this->email       = (array_key_exists('email', $userInfo) ? $userInfo['email'] : '');
            }
        }
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}
