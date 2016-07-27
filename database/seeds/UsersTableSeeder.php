<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'email' => 'test@mail.local',
	        'password' => bcrypt('test'),
	        'first_name' => 'Test',
	        'last_name' => 'User'
        ])->save();
    }
}
