<?php

namespace App\Http\Controllers\API;

use App\Models\File;
use App\Models\Registry;
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
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function store(Request $request)
    {
        return $request->file('upload')->move(public_path('/upload'), $request->file('upload')->getClientOriginalName());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Registry  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Registry $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Registry  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registry $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Registry  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registry $data)
    {
        //
    }
}
