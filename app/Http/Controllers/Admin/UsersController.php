<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index() {
        return view('admin.users.index')->with('users', User::all());
    }
    public function update($id, Request $request) {
        $user = User::find($id);
        if ($user->id !== Auth::id()) {
            $user->is_admin = $request->value;
            $user->save();
            return response(null, Response::HTTP_OK);
        } else {
            return response(null, Response::HTTP_BAD_REQUEST);
        }
    }
}
