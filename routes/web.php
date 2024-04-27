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

Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('index');
    });
});

Route::group(['prefix' => 'community', 'middleware' => ['auth.filament']], function($route){
    $route->get('/', \App\Livewire\PostList::class)->name('community.list');
    $route->get('/create', \App\Livewire\PostCreate::class)->name('community.create');
});