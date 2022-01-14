<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'Admin',
        ]);
        DB::table('users')->insert([
            'name' => "System User",
            'email' => 'system@gmail.com',
            'password' => Hash::make('system-user'),
            'role' => 'SystemUser',
        ]);

    }
}
