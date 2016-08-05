<?php

namespace App\Modules\SchoolAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('SchoolAdmin::dashboard');
    }

    public function store(Request $request)
    {

    }
}
