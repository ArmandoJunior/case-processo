<?php

namespace App\Http\Controllers\API;

use App\Models\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataServiceController extends Controller
{
    public function index()
    {
        return File::all();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!$request->file('upload')) return response()->json([
            'status' => 'File not found.'
        ], 400);

        $result = $request->file('upload')->move(public_path('/upload'), $request->file('upload')->getClientOriginalName());

        return response()->json([
            'status' => 'Success.',
            'File Received' => $result->getFilename(),
        ], 200);
    }
}
