<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) { // You can adjust the loop count based on how many orders you want
            $order = \App\Models\Order::create([
                'timestamp' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'placed' => $faker->boolean,
                'total_price' => $faker->randomFloat(2, 100, 1000),
                'total_qty' => $faker->numberBetween(1, 10),
            ]);

            // Generate random products for each order
            for ($j = 0; $j < 3; $j++) { // You can adjust the loop count based on how many products per order you want
                \App\Models\OrderProduct::create([
                    'order_id' => $order->id,
                    'category' => $faker->word,
                    'brand' => $faker->company,
                    'name' => $faker->word,
                    'price' => $faker->randomFloat(2, 50, 500),
                    'qty' => $faker->numberBetween(1, 5),
                    'img_url' => $faker->imageUrl(),
                ]);
            }
        }
    }
}
