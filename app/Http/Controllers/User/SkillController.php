<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = Education::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's education details retrieved successfully",
            'data' => $education
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationDetailsRequest $storeEducatioDetailsRequest)
    {
        $education = new Education;
        $education->title = $storeEducatioDetailsRequest->title;
        $education->institution = $storeEducatioDetailsRequest->institution;
        $education->duration = $storeEducatioDetailsRequest->startedAt . '-' . $storeEducatioDetailsRequest->endedAt;
        $education->user_id = Auth::user()->id;

        $storeEducation = $education->Save();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's education details stored successfully",
            'data' => $storeEducation
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $education = Education::where('user_id', Auth::user()->id)->find($id);
        if (empty($education)) {
            $this->getJsonResponse();
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's education details retrieved successfully",
            'data' => $education
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationDetailsRequest $updateEducatioDetailsRequest, int $id)
    {
        $education = Education::where('user_id', Auth::user()->id)->find($id);
        if (empty($education)) {
            $this->getJsonResponse();
        }

        $startedAt = explode('-', $education->duration)[0];
        $endedAt = explode('-', $education->duration)[1];
        $newStartedAt = $updateEducatioDetailsRequest->startedAt ?? $startedAt;
        $newEndedAt = $updateEducatioDetailsRequest->endedAt ?? $endedAt;
        $duration = $newStartedAt . '-' . $newEndedAt;

        $education->update([
            'title' => $updateEducatioDetailsRequest->title,
            'institution' => $updateEducatioDetailsRequest->institution,
            'duration' => $duration
        ]);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Education details updated successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $education = Education::where('user_id', Auth::user()->id)->find($id);

        if (empty($education)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Education details not found",
                'user' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $education->delete();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Education details deleted successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }
}
