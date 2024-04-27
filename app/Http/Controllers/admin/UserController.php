<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function userlist()
    {
        if (auth()->user()->user_role == 'admin') 
        {
            $user = User::orderBy('id', 'desc')->get();
            return view('user_list', compact('user'));
        } 
        else{
            return response()->json(['status' => 0, 'message' => 'Something went wrong']);
        }
    }
}
