<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class apiAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['jwt.verify', 'admin']);
    }


    public function roles()
    {

        try {

            $roles = Role::all();

            foreach ($roles as $role) {
                $role['permissions'] = $role->permissions;

                $role->makeHidden('pivot');
                $role->permissions->makeHidden('pivot');
            }

            return response()->json([
                'success' => true,
                'data' => $roles
            ], Response::HTTP_FOUND);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'success' => false,
                'error' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function users()
    {

        try {

            $users = User::all();

            foreach ($users as $user) {
                $user['roles'] = $user->roles; //permissions;

                foreach ($user->roles as $role) {
                    $role['permissions'] = $role->permissions;

                    $role->makeHidden('pivot');
                    $role->permissions->makeHidden('pivot');
                }
            }


            return response()->json([
                'success' => true,
                'data' => $users
            ], Response::HTTP_FOUND);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'success' => false,
                'error' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
