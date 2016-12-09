<?php

namespace App\Http\Controllers;

use App\App;
use App\Task;
use App\User;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $tasks = Task::all();
        $apps = App::all();
        return view('home', compact('users', 'tasks', 'apps'));
    }
}
