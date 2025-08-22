<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()){
        return redirect('/store');
    }
    return view('welcome');
});
