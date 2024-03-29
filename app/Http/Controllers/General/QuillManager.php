<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

class QuillManager extends Controller
{
    public function uploadImageToServer(Request $request): JsonResponse
    {
        if(!auth(CUSTOMER_GUARD_NAME)->check() && !auth()->check()){
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 403);
        }
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['required', File::image()->max('2mb')]
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $imageUrl = uploadFilesFromRequest($request, 'image', '/quill-uploads');
            if(!$imageUrl){
                throw new \Exception('Image upload failed');
            }
            return response()->json([
                'status' => false,
                'message' => 'Image Uploaded Successfully',
                'data' => [
                    'url' => $imageUrl
                ]
            ]);
        } catch (ValidationException $e) {
            $errorsBag = $e->errors();
            $errors = Arr::flatten(array_values((array)$errorsBag));
            $errorMsg = implode(',', $errors);
            return response()->json([
                'status' => false,
                'message' => $errorMsg,
                'data' => null
            ], 400);
        }
    }
}
