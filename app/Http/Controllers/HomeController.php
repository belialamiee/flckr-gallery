<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
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
        $searches = DB::table('searches')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        $searchData = Session::get('searchData');
        $searchTerm = Session::get('searchTerm');
        return view('home',
            [
                'searches' => $searches,
                'searchData' => $searchData,
                'currentUser' => Auth::user()->id,
                'searchTerm' => $searchTerm
            ]
        );
    }

}
