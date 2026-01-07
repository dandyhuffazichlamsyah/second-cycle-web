<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Location;

class PageController extends Controller
{
    public function about()
    {
        // kalau perlu kirim data ke view, taruh di sini
        return view('about');
    }

    public function faq()
    {
        $faqs = Faq::all();
        return view('faq', compact('faqs'));
    }

    public function workshops()
    {
        $locations = Location::all();
        return view('workshops', compact('locations'));
    }
}
