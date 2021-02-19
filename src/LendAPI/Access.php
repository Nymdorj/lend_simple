<?php

namespace App\LendAPI;

use App\LendAPI\Config;

class Access
{
    private $errorMsg;
    private $accessToken;

    public function __construct($code = null)
    {
        if ($code != null) {
            $data = [
                'code'          => $code,
                'redirect_uri'  => Config::REDIRECT_URI,
                'client_id'     => Config::CLIENT_ID,
                'client_secret' => Config::CLIENT_SECRET,
                'grant_type'    => 'authorization_code',
            ];

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, Config::URL . '/oauth/v2/token');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_HEADER, false);
            curl_setopt($curl_handle, CURLOPT_POST, true);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);

            $result = json_decode($buffer, true);

            if (!is_array($result)) {
                $this->errorMsg = 'json decode error.';
            } else {
                $code = $result['code'];
                if (0 != $code) {
                    if (is_array($result['response']))
                        $this->errorMsg = $result['response']['error_description'];
                    else $this->errorMsg = $result['response'];
                } else {
                    $this->accessToken = $result['response']['accessToken'];
                }
            }
        }
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}
