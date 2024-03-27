<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Helpers extends Controller
{
    public function profile(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(User::find(auth()->id()));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Getting User Profile Data',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validate(['password' => 'required|min:6|max:50',]);
            User::find(auth()->id())->update(['password' => Hash::make($data['password'])]);

            return response()->json([
                'success' => true,
                'message' => 'Password Updated Successfully !'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Updating Password',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }


}
