<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends BaseController
{
    public function index()
    {
        return view('index', ['template' => 'users.index']);
    }

    public function list()
    {
        if (auth()->user()->role != 'admin') {
            $users = User::where('id', auth()->user()->id)->get();
        } else {
            $users = User::all();
        }
        
        return response()->json($users);
    }

    public function save(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->update($request->all());
        } else {
            $user = User::create($request->all());
        }
        
        return response()->json([
            'success' => true
        ]);
    }
}
