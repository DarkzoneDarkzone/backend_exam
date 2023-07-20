<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'image_src' => 'image|mimes:jpg,png,jpeg,gif,svg|max:4096',
        ]);

        $profile_img = "";
        if ($request->hasfile('profile_img')) {
            $file = $request->profile_img;
            $profile_img = $this->UploadImage($file);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_img' => $profile_img
        ]);
        $token = $user->createToken('API Token')->accessToken;
        return response(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json(['error' => 'Email or Password has invalid'], 401);
        }
        $token = auth()->user()->createToken('API Token')->accessToken;
        return response(['user' => auth()->user(), 'token' => $token]);
    }

    public function getUser()
    {
        $user = User::all();
        return response()->json(['data' => $user]);
    }
}
