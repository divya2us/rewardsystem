<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
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
        User::create([
            'id' => 1,
            'referer_id' => 1,
            'email' => 'reward@reward.com',
            'password' => Hash::make('123456')
        ]);
    }
}
