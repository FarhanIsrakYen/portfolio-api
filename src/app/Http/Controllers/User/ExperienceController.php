<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceDetailsRequest;
use App\Http\Requests\UpdateExperienceDetailsRequest;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experience = Experience::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's experience details retrieved successfully",
            'data' => $experience
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceDetailsRequest $storeExperienceDetailsRequest)
    {
        $experience = new Experience;
        $experience->position = $storeExperienceDetailsRequest->position;
        $experience->institution = $storeExperienceDetailsRequest->institution;
        $experience->duration = $storeExperienceDetailsRequest->startedAt . '-' . $storeExperienceDetailsRequest->endedAt;
        $experience->job_type = $storeExperienceDetailsRequest->job_type;
        $experience->responsibilities = $storeExperienceDetailsRequest->responsibilities;
        $experience->technologies_used = implode(',', $storeExperienceDetailsRequest->technologies_used);
        $experience->user_id = Auth::user()->id;

        $storeExperience = $experience->Save();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's experience details stored successfully",
            'data' => $storeExperience
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $experience = Experience::where('user_id', Auth::user()->id)->find($id);
        if (empty($experience)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Experience details not found",
                'data' => $id
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's experience details retrieved successfully",
            'data' => $experience
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceDetailsRequest $updateExperienceDetailsRequest, int $id)
    {
        $experience = Experience::where('user_id', Auth::user()->id)->find($id);
        if (empty($experience)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Experience details not found",
                'data' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $startedAt = explode('-', $experience->duration)[0];
        $endedAt = explode('-', $experience->duration)[1];
        $newStartedAt = $updateExperienceDetailsRequest->startedAt ?? $startedAt;
        $newEndedAt = $updateExperienceDetailsRequest->endedAt ?? $endedAt;
        $duration = $newStartedAt . '-' . $newEndedAt;

        $experience->update([
            'position' => $updateExperienceDetailsRequest->position ?? $experience->position,
            'institution' => $updateExperienceDetailsRequest->institution ?? $experience->institution,
            'duration' => $duration,
            'job_type' => $updateExperienceDetailsRequest->job_type ?? $experience->job_type,
            'responsibilities' => $updateExperienceDetailsRequest->responsibilities ?? $experience->responsibilities,
            'technologies_used' => !empty($updateExperienceDetailsRequest->technologies_used) ?
            json_encode($updateExperienceDetailsRequest->technologies_used) : $experience->technologies_used
        ]);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Experience details updated successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $experience = Experience::where('user_id', Auth::user()->id)->find($id);

        if (empty($experience)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Experience details not found",
                'user' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $experience->delete();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Experience details deleted successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }
}
