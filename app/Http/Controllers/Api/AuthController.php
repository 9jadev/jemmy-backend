<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email' => 'required|string|email|max:255|unique:users,email',
            'aboutus' => 'required|string|min:50',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'image' => 'https://picsum.photos/200',
            'password' => bcrypt($request->password),
            'aboutus' => $request->aboutus,
        ]);
        $accessToken = $user->createToken('my-token')->plainTextToken;
        return response(['user' => $user, 'accessToken' => $accessToken, 'status' => true]);
    }
    public function getdata() {
        $id = Auth::id();
        $user = User::find($id);
        return $user;
    }
    public function login(Request $request) {
        $request->validate([
            'nickname' => 'required|string|max:25e',
            'password' => 'required|string|min:8'
        ]);   
        $user = User::where('nickname', $request->nickname)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'nickname' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        $accessToken = $user->createToken('my-token')->plainTextToken;
        return response(['user' => $user, 'accessToken' => $accessToken, 'status' => true]);
    }
}
