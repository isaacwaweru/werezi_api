<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        User::create([
            'name' => 'admin',
            'email' => 'admin@werezi.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
    }
}
