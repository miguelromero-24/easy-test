<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::any('test', function () {
    runnerHelper('App\\Jobs\\ProcessMoviesJob' , 'handle', ['taskData' => ['title' => 'Rambo']]);
    return response()->json(['message' => 'Movie fetch job dispatched!']);
});
