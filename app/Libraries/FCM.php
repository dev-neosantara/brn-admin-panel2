<?php

namespace App\Libraries;
use CodeIgniter\CLI\CLI;

class FCM
{
    /**
     * Send notification to target
     * @param $access_token string required Our server token
     * @param $target_token string required Target token
     * @param $title string required Title of this notification
     * @param $message string required Message of this notification
     * @param $data array optional
     * @param $device_type string optional Additional data to send
     */
    public function send(String $access_token, String $target_token, String $title, String $message, array $data = [], String $device_type = 'android')
    {
        $URL = 'https://fcm.googleapis.com/fcm/send';


        $post_data = '
        {
                "to" : "' . $target_token . '",
                "data" : '.json_encode($data).',
                "notification" : {
                     "body" : "' . $message . '",
                     "title" : "' . $title . '",
                     "type" : "' . $device_type . '",
                     "message" : "' . $message . '",
                     "sound" : "default"
                    },
        }';
        // print_r($post_data);die;

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: Bearer ' . $access_token;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        $rest = curl_exec($crl);
        $result_noti = 1;
        if ($rest === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            // print_r('Curl error: ' . curl_error($crl));exit;
            CLI::error('Curl error: ' . curl_error($crl));exit;
            $result_noti = 0;
        }
        CLI::write($rest);
        // return $result_noti;
    }
}
