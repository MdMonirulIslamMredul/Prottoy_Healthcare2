<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function organisation()
    {
        return view('frontend.organisation');
    }

    public function policy()
    {
        return view('frontend.policy');
    }

    public function customerService()
    {
        return view('frontend.customer-service');
    }

    public function gallery()
    {
        return view('frontend.gallery');
    }
}
