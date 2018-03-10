<?php

namespace App\Http\Controllers\Auth;

use Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('auth.changepassword');
    }

    public function update(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();

        return redirect()->back()->with(['message' => 'Password has been updated']);

    }


}


