<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Las credenciales proporcionadas son incorrectas..'], 401);
        }

        $token = $user->createToken($user->role->name . '-token')->plainTextToken;

        return response()->json(['token' => $token, 'role' => $user->role->name]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
        // $user = $request->user();
        // return response()->json([
        //     'role_id' => $user->role_id,
        //     // Otros campos si es necesario
        // ]);
    }
}
