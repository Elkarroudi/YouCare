<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementOfVolunteer;
use App\Models\User;
use Illuminate\Http\Request;

class Volunteer extends Controller
{
    public function apply(Request $request, Advertisement $advertisement): \Illuminate\Http\JsonResponse
    {
        try {
            AdvertisementOfVolunteer::create([
                'advertisement_id' => $advertisement->id,
                'volunteer_id' => '6e15cea0-5031-44a4-b844-42b083c2973e' // make it dynamic later
            ]);
            return response()->json(['message' => 'Successfully Applied !']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Applying for an advertisement',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
