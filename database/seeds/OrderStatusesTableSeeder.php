<?php

use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->truncate();
        DB::table('order_statuses')->insert([
            ['name' => 'New', 'is_default' => 1],
            ['name' => 'Pending Payment', 'is_default' => 0],
            ['name' => 'Processing', 'is_default' => 0],
            ['name' => 'Shipped', 'is_default' => 0],
            ['name' => 'Delivered', 'is_default' => 0],
            ['name' => 'Canceled', 'is_default' => 0],
        ]);
    }
}
