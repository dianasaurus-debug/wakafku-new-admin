<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Waqif;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin
        $admin_user = User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
        $admin_data = Admin::create([
            'id' => 1,
            'phone' => '0218291711',
            'address' => 'Jl Merbabu No 59 Surabaya',
            'user_id' => 1,
        ]);

        $wakif_user = User::create([
            'id' => 2,
            'name' => 'Diana',
            'email' => 'diana@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);
        $wakif_data = Waqif::create([
            'id' => 1,
            'phone' => '0218291711',
            'gender' => 'female',
            'occupation' => 'Pelajar',
            'address' => 'Jl Merbabu No 59 Surabaya',
            'user_id' => 1,
        ]);
    }
}
