<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $status = StatusAgendamento::orderBy('STATUS')->get();

        return view('admin.home', compact('status'));
    }
}
