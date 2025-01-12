<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::view('allposts', 'allposts');
Route::view('addpost', 'addpost');
Route::view('updatepost', 'updatepost');
Route::view('viewpost', 'viewpost');