<?php

use Illuminate\Support\Facades\Route;

Route::prefix('panel/sistema')->name('panel.sistema.')->group(function(){
	Route::get('/', function(){
		session(['color-topnav' => 'navbar-olive']);
		session(['color-brand' => 'bg-olive']);
		session(['sistema' => 'pnfa']);
		return view('dashboard');
	})->name('PNFA');

	Route::get('/sigrece', function(){
		session(['color-topnav' => 'navbar-yellow']);
		session(['color-brand' => 'bg-yellow']);
		session(['sistema' => 'SIGRECE']);
		return view('dashboard');
	})->name('SIGRECE');

	Route::get('/ms', function(){
		session(['color-topnav' => 'navbar-red']);
		session(['color-brand' => 'bg-red']);
		session(['sistema' => 'MS']);
		return view('dashboard');
	})->name('MS');
});
