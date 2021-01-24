<?php

use App\Models\Child;
use App\Models\Scopes\MyChildScope;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/app');
});

Route::get('/avatar/{id}.svg', function ($id) {
    $avatar_config = Child::withoutGlobalScope(MyChildScope::class)->findOrFail($id)->avatar_config;
    $response = Response::make(view('svg', ['avatar_config' => $avatar_config]), 200);
    $response->header('Content-Type', 'image/svg+xml');
    return $response;
});

Route::get('/home', function () {
    return redirect('/app');
});

Route::get('/s/{slug}', 'App\\Http\\Controllers\\Admin\\DashboardController@view')->middleware('slugauth');
