<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UsersRelations;

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
            'is_active' => true,
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
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Ярче',
            'email' => 'yarche@test.com',
            'phone' =>'88005553535',
            'inn' => '5405356300',
            'kpp' => '540501001',
            'password' => Hash::make('123'),
            'code' => Hash::make('123456'),
            'role' => 1,
            'is_active' => true,
        ]);

        UsersRelations::create([
            'vendor_id' => 3,
            'shop_id' => 1,
            'has_access' => true,
            'can_message' => false,
            'can_see_prices' => false,
        ]);
    }

}
