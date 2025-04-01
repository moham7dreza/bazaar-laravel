<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        mongo_info('view', ['ip' => request()->ip(), 'url' => request()->url()], true);

        return view('welcome');
    }
}
