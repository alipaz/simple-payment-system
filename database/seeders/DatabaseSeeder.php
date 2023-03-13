<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = \App\Models\User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ]);

        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'status' => 'open',
            'product_title' => 'Sample Product',
            'total_cost' => 10000,
        ]);
    }

}
