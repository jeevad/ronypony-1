<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    use \Database\DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        DB::table('countries')->truncate();

        DB::table('countries')->insert([
            [
                'name' => 'India',
                'code' => 'IN',
                'phone_code' => '+91',
                'currency_code' => 'INR',
                'lang_code' => 'hi',
            ],
        ]);

        $this->command->info('Countries seeded');
    }
}
