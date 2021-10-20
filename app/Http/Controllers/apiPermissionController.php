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


        $permission = new Permission();
        $permission->title = $request->title;
        $permission->save();

        return response()->json([
            'success' => true,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
