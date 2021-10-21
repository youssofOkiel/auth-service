<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class apiRoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'admin']);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->only('title'), [
            'title' => 'required|unique:roles'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {

            $role = new Role();
            $role->title = $request->title;
            $role->save();

            return response()->json([
                'success' => true,
                'data' => $role
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'error' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rolePermission(Request $request)
    {
        $validator = Validator::make($request->only(['permission_id', 'role_id']), [
            'permission_id' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $role = Role::find($request->role_id);
        if ($role == null) {
            return response()->json([
                'success' => false,
                'message' => "role not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {

            $role->permissions()->attach($request->permission_id);
            return response()->json([
                'success' => true,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'error' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
