<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->latest('id')->get(); // latest() is by default create_time

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Roles retrieved successfully',
            'data' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $createRoleRequest): JsonResponse
    {
        $role = Role::create(['name' => $createRoleRequest->name]);
        return response()->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Role added successfully',
                'data' => $role
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        if (empty($role)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Role not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Role retrieved successfully',
            'data' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $updateRoleRequest, Role $role): JsonResponse
    {
        $updatedRole = Role::where('id', $role)->update(['name' => $updateRoleRequest->name]);
        if (empty($updatedRole)) {
            return response()->json(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Failed to update role',
                    'data' => $role
                ], 400
            );
        }
        return response()->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Role updated successfully',
                'data' => Role::find($role)
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        try {
            if (!empty($role)) {
                $role->delete();
            }
        } catch (Throwable $th) {
            return response()->json(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Failed to remove role',
                    'data' => $th->getMessage()
                ], 400
            );
        }
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Role removed successfully',
            'data' => []
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function givePermission(UpdatePermissionRequest $permissionRequest, Role $role): JsonResponse
    {
        $role->syncPermissions($permissionRequest->name);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Permission provided successfully',
            'data' => []
        ]);
    }
}
