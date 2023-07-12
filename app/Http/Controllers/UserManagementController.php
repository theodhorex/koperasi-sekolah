<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Model
use App\Models\User;

class UserManagementController extends Controller
{
    public function userManagement(){
        $user = User::all();
        return view('page/user-management/user-management', compact([
            'user'
        ]));
    }

    public function addUser(Request $request){
        User::create([
            'email' => $request -> email,
            'username' => $request -> username,
            'role' => $request -> role,
            'password' => $request -> password
        ]);

        return redirect()->back();
    }

    public function editUser($id){
        $result = User::find($id);
        return view('page/ajax/user-management/edit-user-management', compact('result'));
    }

    public function updateUser(Request $request, $id){
        User::where('id', $id)->update([
            'email' => $request -> emails,
            'username' => $request -> usernames,
            'role' => $request -> roles,
            // 'password' => $request -> passwords
        ]);
    }

    public function deleteUser($id){
        User::where('id', $id)->delete();
        return redirect()->back();
    }
}
