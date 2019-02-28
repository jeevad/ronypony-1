<?php

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Category;
use Database\TruncateTable;
use Faker\Factory as Faker;
use Database\DisableForeignKeys;

class ProductsTableSeeder extends Seeder
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
        $this->truncate('product_images');
        $this->truncate('products');
        $faker = Faker::create();

        $categories = ['Branded Foods', 'Households', 'Veggies & Fruits', 'Kitchen', 'Bread & Bakery'];
        foreach ($categories as $category) {
            $category = Category::whereSlug(str_slug($category))->first();

            $type = array_random(['BASIC', 'VARIATION', 'DOWNLOADABLE', 'VARIABLE_PRODUCT']);
            $name = 'Product for ' . $category->name;
            $product = Product::create([
                'type' => $type,
                'name' => $name,
                'slug' => str_slug($name),
                'sku' => $faker->uuid,
                'description' => $faker->paragraph,
                'status' => 1,
                'in_stock' => 1,
                'qty' => 2,
                'is_taxable' => 1,
                'track_stock' => 1,
                'price' => rand(150.5, 10000.5),
                'weight' => rand(15.5, 100.5),
                'width' => rand(15.5, 100.5),
                'height' => rand(15.5, 100.5),
                'length' => rand(15.5, 100.5),
                'meta_title' => $faker->sentence,
                'meta_description' => $faker->sentence,
            ]);

            $product->images()->createMany([
                [
                    'path' => $faker->imageUrl(),
                    'is_main_image' => 1
                ],
                [
                    'path' => $faker->imageUrl(),
                    'is_main_image' => 0
                ],
                [
                    'path' => $faker->imageUrl(),
                    'is_main_image' => 0
                ],
            ]);
        }

        $this->command->info('Products added!');

    }
}
