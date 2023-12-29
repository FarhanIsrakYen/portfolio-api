<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $permissions = Permission::latest()->get();

        if (empty($permissions)) {
            return response()->json(
                [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'No permission found',
                    'data' => []
                ], 404
            );
        }
        return response()->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Permissions retrieved successfully',
                'data' => $permissions
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePermissionRequest $request): JsonResponse
    {
        $permission = Permission::create([
            'name' => $request->name
        ]);

        return response()->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Permission created successfully',
                'data' => $permission
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): JsonResponse
    {
        if (empty($permission)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Permission not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Permission retrieved successfully',
            'data' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        if (!empty($request->roleId)) {
            $role = Role::where('id',$request->id)->first();
            if (empty($role)) {
                return response()->json(
                    [
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => 'Role doesn\'t exist',
                        'data' => $request->id
                    ], 400
                );
            }
        }
        $updatedPermission = Permission::where(['id' => $permission->id])->update(['name' => $request->name]);
        return response()->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Permission updated successfully',
                'data' => $updatedPermission
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): JsonResponse
    {
        try {
            if (!empty($permission)) {
                $permission->delete();
            }
        } catch (Throwable $th) {
            return response()->json(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Failed to remove permission',
                    'data' => $th->getMessage()
                ], 400
            );
        }
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Permission removed successfully',
            'data' => []
        ]);
    }
}
