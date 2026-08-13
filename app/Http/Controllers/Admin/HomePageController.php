<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        $sections = [


            [
                'title' => 'Home Sliders',
                'route' => route('admin.home.sliders.index'),
                'type' => 'multiple'
            ],

            [
                'title' => 'Why Choose Us',
                'route' => route('admin.home.why.index'),
                'type' => 'multiple'
            ],

        ];

        return view('admin.home.index', compact('sections'));
    }
}