<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExtraParameterRequest;
use App\Http\Requests\UpdateExtraParameterRequest;
use App\Models\ExtraParam;
use Auth;
use Google\Service\CloudMemorystoreforMemcached\UpdateParametersRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExtraInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extraParams = ExtraParam::where('user_id', Auth::id())
                    ->orderBy('parameter_name')
                    ->pluck('parameter_value', 'parameter_name')
                    ->toArray();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's extra params retrieved successfully",
            'data' => $extraParams
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateExtraParameterRequest $request)
    {
        $extraParams = new ExtraParam();
        $extraParams->parameter_name = $request->parameter_name;
        $extraParams->parameter_value = $request->parameter_value;
        $extraParams->user_id = Auth::user()->id;
        $storeExtraParam = $extraParams->Save();
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Extra info stored successfully",
            'data' => $storeExtraParam
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $param)
    {
        $parameter = ExtraParam::where('parameter_name',$param)->first();
        if (empty($parameter)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Parameter not found",
                'data' => $param
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's extra parameter retrieved successfully",
            'data' => $parameter
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExtraParameterRequest $request, string $param)
    {
        $parameter = ExtraParam::where('parameter_name',$param)->first();
        if (empty($parameter)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Parameter not found",
                'data' => $param
            ], Response::HTTP_NOT_FOUND);
        }
        if (!empty($request->parameter_name) && !empty(ExtraParam::where('parameter_name',$request->parameter_name)->first())) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => "Parameter name already in use",
                'data' => $request->parameter_name
            ], Response::HTTP_BAD_REQUEST);
        }
        $parameter->update([
            'parameter_name' => empty($request->parameter_name)? $parameter->parameter_name : $request->parameter_name,
            'parameter_value' => empty($request->parameter_value)? $parameter->parameter_value : $request->parameter_value
        ]);
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "User's extra parameter retrieved successfully",
            'data' => $parameter
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $param)
    {
        $parameter = ExtraParam::where('parameter_name',$param)->first();

        if (empty($parameter)) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Parameter not found",
                'data' => $param
            ], Response::HTTP_NOT_FOUND);
        }

        $parameter->delete();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Parameter deleted successfully",
            'user' => $param
        ], Response::HTTP_ACCEPTED);
    }
}
