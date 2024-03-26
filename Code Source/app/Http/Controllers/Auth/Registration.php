<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Validation;
use App\Models\Organizer;
use App\Models\User;
use App\Models\Volunteer;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Registration extends Controller
{

    public function organizer(Request $request): \Illuminate\Http\JsonResponse
    { return $this->register($request, 'Organizer', Organizer::class);}

    public function volunteer(Request $request): \Illuminate\Http\JsonResponse
    { return $this->register($request, 'Volunteer', Volunteer::class);}


    protected function register(Request $request, $userType, $class): \Illuminate\Http\JsonResponse
    {
        try {
            try {
                $userData = $request->validate([
                    'name' => 'required|string|max:50',
                    'email' => ['required', 'email', Rule::unique('users', 'email')],
                    'password' => 'required|min:6|max:50'
                ]);
            } catch (\Illuminate\Validation\ValidationException $validationException) {
                return response()->json([
                    'message' => 'Data Not Valid',
                    'errors' => $validationException->validator->errors()->all(),
                ], 422);
            }

            $userData['username'] = '@' . uniqid();
            $userData['password'] = Hash::make($userData['password']);
            $userData['type'] = $userType;

            $user = User::create($userData);
            $class::create(['user_id' => $user->id]);

            return \response()->json([
                'success' => true,
                'message' => "$userType Registered Successfully",
                'user' => $user,
            ], 202);

        } catch (\Exception $e) {
            return Response()->json([
                'message' => "Error Registering A New $userType",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
