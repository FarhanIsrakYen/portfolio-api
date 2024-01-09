<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @param array|null $data
     * @param string|null $message
     * @param int|null $statusCode
     * @return JsonResponse
     */
    public function getJsonResponse(array $data = [], string $message = null, int $statusCode = null): JsonResponse
    {
        return match ($statusCode) {
            Response::HTTP_CREATED => response()->json(
                [
                    'status' => Response::HTTP_CREATED,
                    'message' => empty($message) ? 'Data has been created successfully' : $message,
                    'data' => $data
                ]
            ),
            Response::HTTP_NO_CONTENT => response()->json(
                [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => empty($message) ? 'Data has been deleted successfully' : $message,
                    'data' => $data
                ]
            ),
            Response::HTTP_BAD_REQUEST => response()->json(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => empty($message) ? 'Something\'s wrong. Please retry again!' : $message,
                    'data' => $data
                ]
            ),
            Response::HTTP_UNAUTHORIZED => response()->json(
                [
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => empty($message) ? 'Authorization failed!' : $message,
                    'data' => $data
                ]
            ),
            Response::HTTP_FORBIDDEN => response()->json(
                [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => empty($message) ? 'You aren\'t permitted to access this resource' : $message,
                    'data' => $data
                ]
            ),
            Response::HTTP_NOT_FOUND => response()->json(
                [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => empty($message) ? 'No data found' : $message,
                    'data' => $data
                ]
            ),
            default => response()->json(
                [
                    'status' => Response::HTTP_OK,
                    'message' => $message,
                    'data' => $data
                ]
            ),
        };
    }
}
