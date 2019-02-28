<?php

use Illuminate\Database\Seeder;

use App\Models\Category;
use Database\TruncateTable;
use Faker\Factory as Faker;
use Database\DisableForeignKeys;

class CategoriesTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('category_filters');
        $this->truncate('categories');
        $faker = Faker::create();

        $categories = ['Branded Foods', 'Households', 'Veggies & Fruits', 'Kitchen', 'Bread & Bakery'];
        foreach ($categories as $category) {
            $now = now();
            $category = Category::create([
                'name' => $category,
                'slug' => str_slug($category),
                'meta_title' => $faker->sentence,
                'meta_description' => $faker->sentence,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $category->categoryFilter()->create([
                'type' => array_random(['ATTRIBUTE', 'PROPERTY']),
                'filter_id' => array_random([1, 2, 3, 4]),
            ]);
        }

        $this->command->info('Categories added successfully');
    }
}
