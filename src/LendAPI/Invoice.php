<?php

namespace App\LendAPI;

use App\LendAPI\Config;

class Invoice
{
    private $amount;
    private $duration;
    private $description;
    private $successUri;
    private $trackingData;
    private $accessToken;
    private $errorMsg;
    private $invoiceNumber;
    private $qr_link;
    private $qr_string;

    public function __construct($amount, $duration, $description, $successUri, $trackingData, $accessToken)
    {
        $this->amount       = $amount;
        $this->duration     = $duration;
        $this->description  = $description;
        $this->successUri   = Config::REDIRECT_URI . $successUri;
        $this->trackingData = $trackingData;
        $this->accessToken  = $accessToken;
    }

    /**
     * Нэхэмжлэл үүсгэнэ.
     */
    public function createInvoice()
    {
        $data = [
            'amount'       => $this->amount,
            'duration'     => $this->duration,
            'description'  => $this->description,
            'successUri'   => $this->successUri,
            'trackingData' => $this->trackingData,
        ];

        $header = ['x-and-auth-token: ' . $this->accessToken];

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, Config::URL . '/w/invoices');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl_handle, CURLOPT_POST, true);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
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
                $invoice = $result['response'];

                $this->invoiceNumber = $invoice['invoiceNumber'];
                $this->qr_link       = $invoice['qr_link'];
                $this->qr_string     = $invoice['qr_string'];
            }
        }
    }

    /**
     * @param accessToken - lend токен
     * @param invoiceNumber - нэхэмжлэлийн дугаар
     * @return Array - нэхэмжлэлийн мэдээлэл буцаана
     */
    public static function invoiceDetail($accessToken, $invoiceNumber)
    {
        $header = ['x-and-auth-token: ' . $accessToken];

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, Config::URL . "/w/invoices/$invoiceNumber");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl_handle, CURLOPT_POST, false);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);

        $result = json_decode($buffer, true);

        $success = false;
        if (!is_array($result)) {
            $msg = "json decode error.";
        } else {
            $code = $result['code'];
            if (0 != $code) {
                if (is_array($result['response']))
                    $msg = $result['response']['error_description'];
                else $msg = $result['response'];
            } else {
                $success = true;
                $msg = $result['response'];
            }
        }
        return ['success' => $success, 'msg' => $msg];
    }

    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    public function get_qr_Link()
    {
        return $this->qr_link;
    }

    public function get_qr_string()
    {
        return $this->qr_string;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}
