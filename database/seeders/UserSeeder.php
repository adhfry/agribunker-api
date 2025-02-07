<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ahda Firly Barori',
            'email' => 'ahda.creator@gmail.com',
            'hp' => '081233107475',
            'password' => Hash::make(12345678),
        ]);
        User::create([
            'name' => 'Imam Junaidi',
            'email' => 'imamjunaidi976@gmail.com',
            'hp' => '081999320855',
            'password' => Hash::make(12345678),
        ]);
        User::create([
            'name' => 'Cindy Yulia Kartika Sari',
            'email' => 'kcindyyulia@gmail.com',
            'hp' => '082331377472',
            'password' => Hash::make(12345678),
        ]);
    }
}