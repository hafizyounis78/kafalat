<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use App\User;
use Illuminate\Support\Facades\DB;

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

        $this->data['sub_menu'] = 'home';


        return view(admin_vw() . '.home')->with($this->data);

    }


}
