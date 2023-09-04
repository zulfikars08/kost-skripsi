<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userData = [
            [
                'name' => 'superadmin',
                'email' => 'superadmin321@gmail.com',
                'role' => 'superadmin',
                'password' => bcrypt('12345')
            ],
            [ 
            'name' => 'Dika',
            'email' => 'admin321@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('12345')
            ],
            [
                
            'name' => 'Zul',
            'email' => 'user321@gmail.com',
            'role' => 'user',
            'password' => bcrypt('12345')
            ]

            ];

            foreach($userData as $key => $val){
                User::create($val);
            }
    }
}
