<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'name'=>'Cesar Omar Sanchez Tapia',
            'email'=>'cesaromarsancheztapia@gmail.com',
            'password'=> bcrypt('costcesar')
        ])->assignRole('Admin');
        //
      
    }
}
