<?php

namespace Teachat\Http\Controllers\Teacher;

use Teachat\Http\Controllers\Controller;

class VideoCallController extends Controller
{
    /**
     * VideoCall controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display list page.
     *
     * @return view
     */
    public function index()
    {
        return view('teacher.video_call');
    }
}
