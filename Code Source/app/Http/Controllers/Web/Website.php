<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Website extends Controller
{
    public function advertisements(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(Advertisement::withoutTrashed()->where('status', '=', 'Confirmed')->get());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Getting Advertisements Data',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validate([
                'search' => 'required|string',
                'localisation' => 'nullable|string',
            ]);
            $advertisements = Advertisement::withoutTrashed()->where('status', '=', 'Confirmed');

            if ($request->has('localisation')) { $advertisements->where('localisation', '=', $request->input('localisation'));}

            $result = $advertisements->where('title', 'LIKE', '%' . $data['search'] . '%')->get();
            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Getting Advertisements Data',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

}
