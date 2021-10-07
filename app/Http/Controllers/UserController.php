<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get_users(Request $request) {
        return User::get();
    }
    public function get_user(Request $request, $id) {
        return User::find($id);
    }
    public function new_user(Request $request) {        
        if (auth()->user()->role != 'admin') {
            return response("Access denied!", 401);
        }
        $data = $request->validate([
            'login' => 'required|string|unique:users,login',
            'password' => 'required|string|confirmed',  
            'email' => 'required|string|unique:users,email',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'login' => $data['login'],
            'password' => bcrypt($data['password']),  
            'email' => $data['email'],
            'role' => $data['role']
        ]);
        return [
            'message' => 'User created'
        ]; 

    }
    public function update_user(Request $request, $id) {
        $user = User::find($id);
        if($user == null) {
            return response("There is no user with such id!", 401);
        }
        if(auth()->user()->login == $user->login) {
            $user->update($request->all());
            return response([
                'message' => 'User updated'
            ]);
        }
        else {
            return response("Access denied!", 401);
        }
    }
    public function delete_user(Request $request, $id) {
        if(auth()->user()->role != 'admin') {
            return response("You are not an admin!", 401);
        }
        return User::destroy($id);
    }
}
