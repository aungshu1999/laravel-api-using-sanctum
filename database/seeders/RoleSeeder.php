<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin','description'=>'admin'],
            ['name' => 'Manager', 'slug' => 'manager','description'=>'manager'],
            ['name' => 'User', 'slug' => 'user','description'=>'user'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name']],
                ['description'=> $role['description']]
            );
        }
    }
}