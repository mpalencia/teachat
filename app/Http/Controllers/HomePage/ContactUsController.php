<?php

namespace Teachat\Http\Controllers\HomePage;

use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\ContactUsRequest;
use Teachat\Services\MailSender;

class ContactUsController extends Controller
{
    /**
     * Display Contact Us page
     *
     * @return view
     */
    public function index()
    {
        return view('homepage.contact-us');
    }

    /**
     * Send mail to teachat super admin.
     *
     * @return Response
     */
    public function send(ContactUsRequest $contactUs, MailSender $mailSender)
    {
        $contactUs->merge(['first_name' => $contactUs->full_name, 'last_name' => '', 'email' => 'info@teachat.co' /*'info@teachat.co'*/]);

        if ($mailSender->send('email.contact_us', 'Contact Us from Teachat.co', $contactUs->all())) {
            return response()->json(['success' => true, 'message' => 'Thank you for contacting us. Your message has been sent.']);
        }

        return response()->json(['success' => false, 'message' => 'Failed! There is an error occured while sending. Please try again.']);
    }
}
