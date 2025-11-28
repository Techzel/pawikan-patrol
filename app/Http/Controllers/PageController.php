<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function story()
    {
        return view('story.index');
    }

    public function viewer()
    {
        return view('viewer.index');
    }

    public function map()
    {
        return view('map.index');
    }

    public function gallery()
    {
        return view('gallery.index');
    }

    public function dashboard()
    {
        return view('dashboard.index');
    }
}


