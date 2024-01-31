<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFileUploadRequest;

class FileUploadController extends Controller
{
    public function store(StoreFileUploadRequest $request) {
        $validated = $request->validated();

        if ($request->hasFile('img')) {
            $img_url =  'uploads/' . $request->img->store('');
            $data = [
                'success' => true,
                'img_url' => $img_url
            ];
            return response()->json($data);
        }

    }
}
