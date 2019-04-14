<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.index');
    }
//    public function getUserData(Request $request)
//    {
//        if(Auth::user() !== null){
//            $user = User::findOrFail(Auth::id());
//
//            return response()->json(['name' => $user->email, 'password' => decrypt($user->password)]);
//        }
//    }
}
