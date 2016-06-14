<?php namespace Teachat\Services;

use Mail;

/**
 * A service class to send email
 *
 * @author gab
 * @package Teachat\Services
 * @return boolean
 */
class MailSender
{
    /**
     * Send mail to guest for password reset
     *
     * @param string $view
     * @param string $subject
     * @param array $data
     * @param array $opt
     * @return void
     */
    public function send($view, $subject, $data, $opt = array())
    {
        $sendMail = Mail::send($view, ['data' => $data], function ($message) use ($data, $subject) {
            $message->from('info@teachat.co', 'Teachat.co')->subject($subject);
            $message->to($data['email'], $data['first_name'] . ' ' . $data['last_name'])->subject($subject);
        });

        return $sendMail;
    }
}
