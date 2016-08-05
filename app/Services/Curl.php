<?php namespace Teachat\Services;

/**
 * A service class to call CURL Request
 *
 * @author gab
 * @package Teachat\Services
 * @return string
 */
class Curl
{
    /**
     * Call Curl Request.
     *
     * @param string $fields
     * @return void
     */
    public function call($fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://a.floox.com:1337/users");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'app_id: 5799b1d7ef84b7801e10e94e', 'access_token: JZu7WnX14jA1z0M7ytaf43xc'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
