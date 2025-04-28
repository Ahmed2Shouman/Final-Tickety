<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            [
                'name' => 'Free',
                'description' => 'Basic access to Tickty with limited features.',
                'price' => 0.00,
                'cinema_count' => 1,
                'features' => '{"basic_features": true, "advanced_features": false}',
                'stripe_plan_id' => 'prod_SCiHxaR1CJ1wxH',
                'stripe_price_id' => 'price_1RIIrF2LTXz7PItpgaNCLAoI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plus',
                'description' => 'Access to all basic features and some advanced features.',
                'price' => 99.99,
                'cinema_count' => 5,
                'features' => '{"basic_features": true, "advanced_features": true}',
                'stripe_plan_id' => 'prod_SCiIv0K76ESjCh',
                'stripe_price_id' => 'price_1RIIrW2LTXz7PItpIzXDXJgf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'premium',
                'description' => 'more and more',
                'price' => 150.00,
                'cinema_count' => 10,
                'features' => '{"basic_features": true, "advanced_features": true}',
                'stripe_plan_id' => 'prod_SCiJDhlQ7UWOiH',
                'stripe_price_id' => 'price_1RIIsi2LTXz7PItp3nqo8tAc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
