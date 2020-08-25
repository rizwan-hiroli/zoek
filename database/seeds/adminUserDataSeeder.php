<?php

use Illuminate\Database\Seeder;
use App\User;

class adminUserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
	            'name' => 'Zoek Admin',
	            'email' => 'admin@admin.com',
	            'password' => bcrypt('password')
	    ]);
    }
}
