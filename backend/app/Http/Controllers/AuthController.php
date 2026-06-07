<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validar que los campos no se envíen vacíos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Buscar al usuario en la base de datos por su correo
        $user = User::where('email', $request->email)->first();

        // 3. Verificar si no existe o si la contraseña no coincide
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales ingresadas no son válidas.'
            ], 401);
        }

        // 4. Crear el token de acceso seguro con Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Responder con éxito al Frontend
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}