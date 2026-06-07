<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate; // IMPORTANTE: Agregar esto

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

    // NUEVO MÉTODO PARA EL PASO 4.5
    public function me(Request $request) 
    {
        $user = $request->user();
        
        return response()->json([
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'rol'      => $user->rol,
            'permisos' => [
                'crear'    => Gate::allows('crear-producto'),
                'editar'   => Gate::allows('editar-producto'),
                'eliminar' => Gate::allows('eliminar-producto'),
            ],
        ]);
    }
}