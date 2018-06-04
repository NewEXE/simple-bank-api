<?php

namespace App\Http\Controllers;

use App\Facades\Api;

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
//        $newUser = Api::AddCustomer('Vasya', '4qlGROCv4CGDb6zQ');


        $transactions = Api::getAllTransactions();

        return view('home', compact('transactions', 'users'));
    }
}
