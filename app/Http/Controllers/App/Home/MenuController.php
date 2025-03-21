<?php

namespace App\Http\Controllers\App\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\MenuCollection;
use App\Models\Content\Menu;

class MenuController extends Controller
{
    public function index()
    {
        return new MenuCollection(Menu::whereNull('parent_id')->get());
    }
}
