<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementOfVolunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Organizer extends Controller
{
    public function statistic(): \Illuminate\Http\JsonResponse
    {
        try {
            $advCount = DB::table('organizers')
                ->where('user_id', '=', auth()->id())
                ->join('advertisements', 'organizers.id', '=', 'advertisements.organizer_id')
                ->count();

            return response()->json(['AdvertisementsCount' => $advCount]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Getting Volunteer Statistic',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function acceptApplication(AdvertisementOfVolunteer $advertisementOfVolunteer): \Illuminate\Http\JsonResponse
    {
        try {
            $advertisementOfVolunteer->status = 'Confirmed';
            $advertisementOfVolunteer->save();
            return response()->json([
                'success' => true,
                'message' => 'Application Was Confirmed Successfully !',
                'advertisement' => $advertisementOfVolunteer,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Accepting Volunteer Application',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOrganizerVolunteers(): \Illuminate\Http\JsonResponse
    {
        try {
            $volunteers = DB::table('organizers')
                ->where('organizers.user_id', '=', auth()->id())
                ->join('advertisements', 'organizers.id', '=', 'advertisements.organizer_id')
                ->join('advertisement_of_volunteers', 'advertisements.id', '=', 'advertisement_of_volunteers.advertisement_id')
                ->join('volunteers', 'advertisement_of_volunteers.volunteer_id', '=', 'volunteers.id')
                ->join('users', 'volunteers.user_id', '=', 'users.id')
                ->select('users.name', 'users.email', 'advertisement_of_volunteers.*', 'advertisements.title', 'advertisements.date', 'advertisements.localisation', 'advertisements.required_skills')
                ->get();

            return response()->json($volunteers);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Getting Volunteers Data',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

}
