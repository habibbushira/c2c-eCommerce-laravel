<?php

use Illuminate\Database\Seeder;

use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the cush database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role();
        $role->name = "Customer";
        $role->description = "a normal user";
        $role->save();

        $role = new Role();
        $role->name = "Administrator";
        $role->description = "A user with full control of the system";
        $role->save();
    }
}