<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(UserGroupTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AddressTableSeeder::class);

    }
}
