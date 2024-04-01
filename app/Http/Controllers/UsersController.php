<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreate;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(UserCreate $request)
    {
        try {
            /*
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;

            $user->save();
            */
            $data = $request->all();
            User::create([
                'name' => $data['name'],
                'email' => 'johan.guzmanpe@gmail.com',
                'password' => bcrypt('12345678')
            ]);
            return response()->json(['status' => true, 'message' => 'User created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
