<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // User role
        // $user = \Auth::user();
        // dd(\App\Models\Role::where('name', 'user')->first());
        // $res = $user
        //     ->roles()
        //     ->attach(\App\Models\Role::where('name', 'user')->first());
        // dd($res);

        // $roles = \Auth::user()->roles->pluck('name')->toArray();
        // if (in_array('admin', $roles)) {
        //         die('in');
        // }
        // dd($roles);
        // dd($roles->toArray());
        // return view('home');
        return view('frontend.home');
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
