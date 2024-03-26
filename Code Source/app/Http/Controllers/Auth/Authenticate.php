<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Authenticate extends Controller
{
    public function __construct()
    { $this->middleware('auth:api', ['except' => ['login']]);}

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->isMethod('POST')) {
                try {
                    $credentials = $request->validate([
                        'email' => 'required|email',
                        'password' => 'required|min:6|max:50',
                    ]);
                } catch (\Illuminate\Validation\ValidationException $validationException) {
                    return response()->json([
                        'message' => 'Data Not Valid',
                        'errors' => $validationException->validator->errors()->all(),
                    ], 422);
                }

                if ($token = auth()->attempt($credentials)) {
                    return $this->respondWithToken($token);
                }
                return response()->json([
                    'message' => 'Unauthorized'
                ], 422);

            } else if ($request->isMethod('GET')) {
                return response()->json(['message' => 'You Need To Be Logged In ']);
            }

        } catch (\Exception $e) {

            return Response()->json([
                'message' => "Error Login in !",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);

        } catch (\Exception $e) {
            return Response()->json([
                'message' => "Error Login out !",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    { return $this->respondWithToken(auth()->refresh());}

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 ,
            'user' => User::find(auth()->id()),
        ], 202);
    }
}
