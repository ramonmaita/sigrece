<?php

use Illuminate\Support\Facades\Route;

Route::prefix('panel/sistema')->name('panel.sistema.')->group(function(){
	Route::get('/', function(){
		session(['color-topnav' => 'navbar-olive']);
		session(['sistema' => 'pnfa']);
		return view('dashboard');
	})->name('PNFA');
});
