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
    public function index()
    {

        $user = User::find(Auth::user()->id);

        $roles = Role::all();

        foreach ($roles as $role) {
            $role['permissions'] = $role->permissions;
        }

        return response()->json([
            'success' => false,
            'user' => $user->roles,
            'data' => $roles
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
