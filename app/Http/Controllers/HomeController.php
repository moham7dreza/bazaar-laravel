<?php

namespace App\Http\Controllers;

use App\Events\PackageSent;

class HomeController extends Controller
{
    public function index()
    {
        mongo_info('view', ['ip' => request()->ip(), 'url' => request()->url()], true);
        PackageSent::dispatch('processed', 'prosper');
        PackageSent::dispatch('delivered', 'olamide');

        return view('welcome');
    }
}
