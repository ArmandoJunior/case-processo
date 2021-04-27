<?php

use App\Http\Resources\RegistriesCollection;
use App\Models\Registry;
use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function() {
    $except = ['except' => ['create', 'edit', 'show', 'update', 'destroy']];
    Route::resource('files', 'DataServiceController', $except);
    Route::get('registries', function () {
        return new RegistriesCollection(Registry::paginate());
    });
});
