<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application Dashboard
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searches = DB::table('searches')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->groupBy('searchTerm')->get();
        $searchData = Session::get('searchData');
        return view('home',
            [
                'searches' => $searches,
                'searchData' => $searchData
            ]
        );
    }

}
