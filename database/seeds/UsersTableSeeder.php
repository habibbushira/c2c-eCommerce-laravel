<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Role;

use App\UserSecurity;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the cush database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = Role::where('name', 'Administrator')->first();
        $customer = Role::where('name', 'Customer')->first();

        $user = new User;
        $user->name = "Habib Bushira";
        $user->phone_number = "0921951290";
        $user->password = bcrypt("password");
        $user->country = "Ethiopia";
        $user->region = "Amhara";
        $user->city = "Kombolcha";
        $user->address1 = "Kuteba";
        $user->save();

        $user->roles()->attach($admin);
        $user->roles()->attach($customer);

        $user_query = new UserSecurity;
        $user_query->query_id = 1;
        $user_query->user_id = $user->id;
        $user_query->answer = Hash::make('laptop');
        $user_query->save();
    }
}