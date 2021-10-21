<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class apiPermissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'admin']);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->only('title'), [
            'title' => 'required|unique:permissions'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $permission = new Permission();
            $permission->title = $request->title;
            $permission->save();

            return response()->json([
                'success' => true,
                'permission' => $permission
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'error' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
