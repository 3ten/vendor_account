<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Shop',
            'email' => 'shop@test.com',
            'phone' => '+79991234567',
            'inn' => '12345678',
            'kpp' => '87654321',
            'password' => Hash::make('admin'),
            'code' => Hash::make('1234'),
            'role' => 0,
        ]);     

        User::create([
            'name' => 'Vendor',
            'email' => 'vendor@test.com',
            'phone' => '+79991232233',
            'inn' => '12341234',
            'kpp' => '87651234',
            'password' => Hash::make('secret'),
            'code' => Hash::make('12345'),
            'role' => 1,
        ]);
    }

}
