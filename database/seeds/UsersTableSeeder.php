<?php

use Illuminate\Database\Seeder;
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
            'name' => 'Admin',
            'email' => 'admin@vta.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'user_type' => 'Admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Saman Priyantha',
            'email' => 'oic@vta.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'user_type' => 'OIC',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Saneth Sarantha',
            'email' => 'ma@vta.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'user_type' => 'MA',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Udara Rajapakshe',
            'email' => 'mr@vta.lk',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'user_type' => 'MR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $user = config('roles.models.defaultUser')::where('email', '=', 'admin@vta.lk')->first();
        $user->attachRole($adminRole);

        $oicRole = config('roles.models.role')::where('name', '=', 'OIC')->first();
        $user = config('roles.models.defaultUser')::where('email', '=', 'oic@vta.lk')->first();
        $user->attachRole($oicRole);

        $maRole = config('roles.models.role')::where('name', '=', 'MA')->first();
        $user = config('roles.models.defaultUser')::where('email', '=', 'ma@vta.lk')->first();
        $user->attachRole($maRole);

        $mrRole = config('roles.models.role')::where('name', '=', 'MR')->first();
        $user = config('roles.models.defaultUser')::where('email', '=', 'mr@vta.lk')->first();
        $user->attachRole($mrRole);
    }
}
