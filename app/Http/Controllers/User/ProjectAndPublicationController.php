<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectAndPublicationsRequest;
use App\Http\Requests\UpdateProjectAndPublicationsRequest;
use App\Models\ProjectAndPublication;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectAndPublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = ProjectAndPublication::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's projects details retrieved successfully",
            'data' => $project
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectAndPublicationsRequest $storeProjectAndPublicationsRequest)
    {
        $project = new ProjectAndPublication;
        $project->name = $storeProjectAndPublicationsRequest->name;
        $project->category = $storeProjectAndPublicationsRequest->category;
        $project->duration = $storeProjectAndPublicationsRequest->startedAt . '-' . $storeProjectAndPublicationsRequest->endedAt;
        $project->link = $storeProjectAndPublicationsRequest->link;
        $project->description = $storeProjectAndPublicationsRequest->description;
        $project->technologies_used = implode(',', $storeProjectAndPublicationsRequest->technologies_used);
        $project->images = implode(',', $storeProjectAndPublicationsRequest->images);
        $project->user_id = Auth::user()->id;

        $storeProject = $project->Save();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's project details stored successfully",
            'data' => $storeProject
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $project = ProjectAndPublication::where('user_id', Auth::user()->id)->find($id);
        if (empty($project)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Project details not found",
                'user' => $id
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's project details retrieved successfully",
            'data' => $project
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectAndPublicationsRequest $updateProjectAndPublicationsRequest, int $id)
    {
        $project = ProjectAndPublication::where('user_id', Auth::user()->id)->find($id);
        if (empty($project)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Project details not found",
                'user' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $startedAt = explode('-', $project->duration)[0];
        $endedAt = explode('-', $project->duration)[1];
        $newStartedAt = $updateProjectAndPublicationsRequest->startedAt ?? $startedAt;
        $newEndedAt = $updateProjectAndPublicationsRequest->endedAt ?? $endedAt;
        $duration = $newStartedAt . '-' . $newEndedAt;

        $techUsed = !empty($updateProjectAndPublicationsRequest->technologies_used)?
            implode(',', $updateProjectAndPublicationsRequest->technologies_used) : $project->technologies_used;

        $images = !empty($updateProjectAndPublicationsRequest->images)?
            implode(',', $updateProjectAndPublicationsRequest->images) : $project->images;

        $project->update([
            'name' => !empty($updateProjectAndPublicationsRequest->name)? $updateProjectAndPublicationsRequest->name: $project->name,
            'category' => !empty($updateProjectAndPublicationsRequest->category)? $updateProjectAndPublicationsRequest->category: $project->category,
            'link' => !empty($updateProjectAndPublicationsRequest->link)? $updateProjectAndPublicationsRequest->link: $project->link,
            'description' => !empty($updateProjectAndPublicationsRequest->description)? $updateProjectAndPublicationsRequest->description: $project->description,
            'technologies_used' => $techUsed,
            'images' => $images,
            'duration' => $duration
        ]);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Project details updated successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $project = ProjectAndPublication::where('user_id', Auth::user()->id)->find($id);

        if (empty($project)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Project details not found",
                'user' => $id
            ], Response::HTTP_NOT_FOUND);
        }

        $project->delete();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Project details deleted successfully",
            'user' => $id
        ], Response::HTTP_ACCEPTED);
    }
}
