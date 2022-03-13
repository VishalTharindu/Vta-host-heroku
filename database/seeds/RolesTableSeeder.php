<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ],
            [
                'name'        => 'OIC',
                'slug'        => 'oic',
                'description' => 'Officer in Charge Role',
                'level'       => 5,
            ],
            [
                'name'        => 'MR',
                'slug'        => 'mr',
                'description' => 'Management Representative Role',
                'level'       => 4,
            ],
            [
                'name'        => 'MA',
                'slug'        => 'ma',
                'description' => 'Management Assistant Role',
                'level'       => 3,
            ],
            [
                'name'        => 'Instructor',
                'slug'        => 'instructor',
                'description' => 'Instructor Role',
                'level'       => 2,
            ],
            [
                'name'        => 'Demonstrator',
                'slug'        => 'demonstrator',
                'description' => 'Demonstrator Role',
                'level'       => 1,
            ],
            [
                'name'        => 'Unverified',
                'slug'        => 'unverified',
                'description' => 'Unverified Role',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
