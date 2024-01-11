<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'email_verified_at' => '1995-12-07',
            'password' => bcrypt('12345678'),
            'phone' => '01969279140',
            'address' => 'Dhaka, Bangladesh',
            'website' => 'test.com',
            'dob' => '1995-12-07',
            'objective' => 'test',
            'interests' => 'test',
            'roles' => json_encode(['ROLE_ADMIN','ROLE_USER'])
        ]);
    }
}
