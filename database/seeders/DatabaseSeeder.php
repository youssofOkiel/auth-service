<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => "Admin",
            'email' => 'Admin@gmail.com',
            'password' => Hash::make('qwer1234'),
        ]);

        DB::table('roles')->insert([
            'title' => "Admin"
        ]);

        DB::table('roles')->insert([
            'title' => "Manager"
        ]);

        DB::table('roles')->insert([
            'title' => "user"
        ]);

        DB::table('permissions')->insert([
            'title' => "see_roles"
        ]);

        DB::table('permissions')->insert([
            'title' => "add_role"
        ]);

        DB::table('permissions')->insert([
            'title' => "grant"
        ]);
        DB::table('permissions')->insert([
            'title' => "revok"
        ]);

        $admin = User::find(1);
        $admin->roles()->attach(1);
    }
}
