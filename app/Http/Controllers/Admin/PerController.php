<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerController extends Controller
{
    public function index()
	{
		return view('panel.admin.per.index');
	}
}
