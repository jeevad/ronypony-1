<?php

use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
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
        DB::table('states')->truncate();
        $states = array(
            array('name' => "Andaman and Nicobar Islands", 'code' => 'IN-AN', 'country_id' => 1),
            array('name' => "Andhra Pradesh", 'code' => 'AP', 'country_id' => 1),
            array('name' => "Arunachal Pradesh", 'code' => 'IN-AR', 'country_id' => 1),
            array('name' => "Assam", 'code' => 'IN-AS', 'country_id' => 1),
            array('name' => "Bihar", 'code' => 'IN-BR', 'country_id' => 1),
            array('name' => "Chandigarh", 'code' => 'IN-CH', 'country_id' => 1),
            array('name' => "Chhattisgarh", 'code' => 'IN-CT', 'country_id' => 1),
            array('name' => "Dadra and Nagar Haveli", 'code' => 'IN-DN', 'country_id' => 1),
            array('name' => "Daman and Diu", 'code' => 'IN-DD', 'country_id' => 1),
            array('name' => "Delhi", 'code' => 'IN-DL', 'country_id' => 1),
            array('name' => "Goa", 'code' => 'IN-GOA', 'country_id' => 1),
            array('name' => "Gujarat", 'code' => 'IN-GJ', 'country_id' => 1),
            array('name' => "Haryana", 'code' => 'IN-HR', 'country_id' => 1),
            array('name' => "Himachal Pradesh", 'code' => 'IN-HP', 'country_id' => 1),
            array('name' => "Jammu and Kashmir", 'code' => 'IN-JK', 'country_id' => 1),
            array('name' => "Jharkhand", 'code' => 'IN-JH', 'country_id' => 1),
            array('name' => "Karnataka", 'code' => 'IN-KA', 'country_id' => 1),
            array('name' => "Kerala", 'code' => 'IN-KL', 'country_id' => 1),
            array('name' => "Lakshadweep", 'code' => 'IN-LD', 'country_id' => 1),
            array('name' => "Madhya Pradesh", 'code' => 'IN-MP', 'country_id' => 1),
            array('name' => "Maharashtra", 'code' => 'IN-MH', 'country_id' => 1),
            array('name' => "Manipur", 'code' => 'IN-MN', 'country_id' => 1),
            array('name' => "Meghalaya", 'code' => 'IN-ML', 'country_id' => 1),
            array('name' => "Mizoram", 'code' => 'IN-MZ', 'country_id' => 1),
            array('name' => "Nagaland", 'code' => 'IN-NL', 'country_id' => 1),
            array('name' => "Odisha", 'code' => 'IN-OR', 'country_id' => 1),
            array('name' => "Punjab", 'code' => 'IN-PB', 'country_id' => 1),
            array('name' => "Rajasthan", 'code' => 'IN-RJ', 'country_id' => 1),
            array('name' => "Sikkim", 'code' => 'IN-SK', 'country_id' => 1),
            array('name' => "Tamil Nadu", 'code' => 'IN-TN', 'country_id' => 1),
            array('name' => "Telangana", 'code' => 'IN-TG', 'country_id' => 1),
            array('name' => "Tripura", 'code' => 'IN-TR', 'country_id' => 1),
            array('name' => "Uttar Pradesh", 'code' => 'IN-UP', 'country_id' => 1),
            array('name' => "Uttarakhand", 'code' => 'IN-UT', 'country_id' => 1),
            array('name' => "West Bengal", 'code' => 'IN-WB', 'country_id' => 1),
        );
        DB::table('states')->insert($states);

        $this->command->info('States seeded');

    }
}
