<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return \Illuminate\Support\Facades\Hash::make("12345678");
    return view('welcome');
});

Route::get('/generate-docs', function () {
    $output = [];
    \Artisan::call('l5-swagger:generate', $output);
    \Artisan::call('artisan:migrate', $output);
    dd($output);
});
