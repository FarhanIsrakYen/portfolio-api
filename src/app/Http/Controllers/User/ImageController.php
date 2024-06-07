<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $username = explode('.', $request->image)[0];
        $user = User::where('username',$username)->first();
        if (empty($user) || $user->photo == 'default.png') {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Image not found",
                'data' => $request->image
            ], Response::HTTP_NOT_FOUND);
        }
        $storePath = '/public/images/';
        $imageName = $user->username . '.' . 'jpeg';
        if (Storage::exists($storePath . $imageName)) {
            return response(Storage::get($storePath . $imageName), 200)->header('Content-Type', 'image/jpeg');
        }
        $publicLink = "https://drive.google.com/uc?id=" . $user->photo;
        $imageContent = file_get_contents($publicLink);

        return response($imageContent, 200)->header('Content-Type', 'image/jpeg');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $uploadImageRequest)
    {
        $image = $uploadImageRequest->file('image');
        $storePath = '/public/images/';
        $imageName = Auth::user()->username . '.' . 'jpeg';
        Storage::delete($storePath . $imageName);
        $image->storeAs($storePath,$imageName);

        $manager = new ImageManager(new Driver());
        $storedPath = $manager->read(storage_path() . '/app/public/images/' . $imageName);

        $image = $manager->read($storedPath)->scale(height:200)->toPng();
        $image->save(storage_path() . '/app/public/images/' . $imageName);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'message' => "Image uploaded successfully",
            'data' => $imageName
        ], Response::HTTP_ACCEPTED);
    }
}
