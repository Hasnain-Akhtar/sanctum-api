<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


// Route::view('allposts', 'allposts');
// Route::view('addpost', 'addpost');
// Route::view('updatepost', 'updatepost');
// Route::view('viewpost', 'viewpost');


// Route for the posts index page
Route::get('/allposts', function () {
    return view('posts.index');
})->name('posts.index');

// Route for the create post page
Route::get('/posts/createpost', function () {
    return view('posts.createpost');
})->name('posts.create');


// Route for the viewpost post page
Route::get('/posts/viewpost', function () {
    return view('posts.viewpost');
})->name('posts.viewpost');

// Route for the contact post page
Route::get('/posts/contact', function () {
    return view('posts.contact');
})->name('posts.contact');

// Route for the updatepost post page
Route::get('/posts/updatepost', function () {
    return view('posts.updatepost');
})->name('posts.updatepost');


Route::get('/posts/editor_quotes', function () {
    return view('posts.editor_quotes');
})->name('posts.editor_quotes');

Route::get('/posts/live-videos', function () {
    return view('posts.live-videos');
})->name('posts.live-videos');

