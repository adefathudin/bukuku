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

    public function profile()
    {
        $user = auth()->user();
        return view('index', [
            'template' => 'users.profile',
            'user' => $user
        ]);
    }

    public function list()
    {
        if (auth()->user()->role != 'admin') {
            $users = User::where('id', auth()->user()->id)->get();
        } else {
            $users = User::where('id', '!=', auth()->user()->id)->get();
        }
        
        return response()->json($users);
    }

    public function save(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->update($request->all());
        } else {
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['error' => 'Email already exists'], 409);
            }
            $user = User::create($request->all());
        }
        
        return response()->json([
            'success' => true
        ]);
    }

    public function detail()
    {
        $user = User::find(auth()->user()->id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function delete(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        if (!$request->id) {
            return response()->json(['error' => 'User ID is required'], 400);
        }
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'User not found'], 404);
    }
}
