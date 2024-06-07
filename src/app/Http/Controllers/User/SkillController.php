<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's skills retrieved successfully",
            'data' => $skills
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $storeSkillRequest)
    {
        $userSkills = [];
        foreach ($storeSkillRequest->skills as $skill) {
            $skill['user_id'] = Auth::user()->id;
            $userSkills[] = $skill;
        }
        Skill::insert($userSkills);
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's skills stored successfully",
            'data' => $userSkills
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $skills = Skill::where('user_id', Auth::user()->id)->find($id);
        if (empty($skills)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Skill not found",
                'data' => $id
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's skill retrieved successfully",
            'data' => $skills
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $updateSkillRequest, int $id)
    {
        $skill = Skill::where('user_id', Auth::user()->id)->find($id);
        if (empty($skill)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Skill not found",
                'data' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $skill->update([
            'topic' => empty($updateSkillRequest->topic)? $skill->topic : $updateSkillRequest->topic,
            'percentage' => empty($updateSkillRequest->percentage)? $skill->percentage : $updateSkillRequest->percentage
        ]);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Skill updated successfully",
            'user' => $skill
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $skill = Skill::where('user_id', Auth::user()->id)->find($id);

        if (empty($skill)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Skill not found",
                'user' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $skill->delete();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Skill deleted successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }
}
