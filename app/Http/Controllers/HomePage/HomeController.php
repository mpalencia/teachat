<?php

namespace Teachat\Http\Controllers\HomePage;

use Teachat\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display Home page
     *
     * @return view
     */
    public function index()
    {
        return view('homepage.index');
    }

    /**
     * Display Terms of Use page.
     *
     * @return view
     */
    public function getTermsOfUse()
    {
        return view('homepage.terms-of-use');
    }

    /**
     * Display Privacy Policy page.
     *
     * @return view
     */
    public function getPrivacyPolicy()
    {
        return view('homepage.privacy-policy');
    }

    public function addSchool()
    {
        return view('homepage.add-school');
    }
}
