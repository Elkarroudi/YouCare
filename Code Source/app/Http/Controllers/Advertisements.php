<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class Advertisements extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(Advertisement::withoutTrashed()->get());
        } catch (\Exception $e) {
            return $this->errorMessage(['Error Fetching Advertisements Data', $e->getMessage(), 500]);
        }
    }

    public function show(Advertisement $advertisement): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json($advertisement);
        } catch (\Exception $e) {
            return $this->errorMessage(['Error Fetching Advertisements Data', $e->getMessage(), 500]);
        }
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->validateAdvertisementData($request);
            $data['required_skills'] = json_encode($data['required_skills']);
            $data['organizer_id'] = '4bd8b81d-3089-4b84-a83c-dc73a18fe860'; // Make it dynamic After

            $advertisement = Advertisement::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Advertisement Was Created Successfully !',
                'advertisement' => $advertisement,
            ]);

        } catch (\Exception $e) {
            return $this->errorMessage(['Error Creating A New Advertisement', $e->getMessage(), 500]);
        }
    }

    public function update(Request $request, Advertisement $advertisement): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->validateAdvertisementData($request);
            $data['required_skills'] = json_encode($data['required_skills']);

            $advertisement->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Advertisement Was Updated Successfully !',
                'advertisement' => $advertisement,
            ]);

        } catch (\Exception $e) {
            return $this->errorMessage(['Error Updating An Advertisement', $e->getMessage(), 500]);
        }
    }

    public function delete(Advertisement $advertisement): \Illuminate\Http\JsonResponse
    {
        try {
            $advertisement->delete();
            return response()->json(['message', 'Advertisement was Deleted Successfully !']);
        } catch (\Exception $e) {
            return $this->errorMessage(['Error Deleting Advertisement', $e->getMessage(), 500]);
        }
    }

    public function deletePermanently($id): \Illuminate\Http\JsonResponse
    {
        try {
            Advertisement::withTrashed()->findOrFail($id)->forceDelete();
            return response()->json(['message', 'Advertisement was Force Deleted Successfully !']);
        } catch (\Exception $e) {
            return $this->errorMessage(['Error Deleting Advertisement', $e->getMessage(), 500]);
        }
    }

    public function restore($id): \Illuminate\Http\JsonResponse
    {
        try {
            Advertisement::onlyTrashed()->findOrFail($id)->restore();
            return response()->json(['message', 'Advertisement was Restored Successfully !']);
        } catch (\Exception $e) {
            return $this->errorMessage(['Error Restoring Advertisement', $e->getMessage(), 500]);
        }
    }

    public function validateToShow(Advertisement $advertisement): \Illuminate\Http\JsonResponse
    {
        try {
            $advertisement->status = 'Confirmed';
            $advertisement->save();
            return response()->json([
                'success' => true,
                'message' => 'Advertisement Was Confirmed Successfully !',
                'advertisement' => $advertisement,
            ]);        } catch (\Exception $e) {
            return $this->errorMessage(['Error Confirming An Advertisement', $e->getMessage(), 500]);
        }
    }



    protected function errorMessage($toCatch): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $toCatch[0],
            'errors' => $toCatch[1],
        ], $toCatch[2]);
    }

    protected function validateAdvertisementData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|min:10|max:255',
            'description' => 'required|min:10',
            'type' => 'required',
            'date' => 'required|date',
            'localisation' => 'required',
            'required_skills' => 'required',
        ]);
    }
}
