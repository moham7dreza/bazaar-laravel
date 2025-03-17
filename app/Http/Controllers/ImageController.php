<?php

namespace App\Http\Controllers;

use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        return view('image');
    }

    public function store(Request $request, ImageService $imageService)
    {
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'category-images');
            // $resutl = $imageService->save($request->image);
            // $resutl = $imageService->fitAndSave($request->image, 100, 200);
            $resutl = $imageService->createIndexAndSave($request->image);
            return 'ok';
        }
    }
}
