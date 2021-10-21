<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class apiUserController extends Controller
{
    //

    public function addRole(Request $request)
    {
        $validator = Validator::make($request->only(['user_id', 'role_id']), [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $user = User::find($request->user_id);
        if ($user == null) {
            return response()->json([
                'success' => false,
                'message' => "user not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $user->roles()->attach($request->role_id);
            return response()->json([
                'success' => true,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'error' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
