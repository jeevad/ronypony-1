<?php

use Illuminate\Database\Seeder;

class UserGroupTableSeeder extends Seeder
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
        DB::table('user_groups')->truncate();

        DB::table('user_groups')->insert([
            [
                'name' => 'percentage',
                'discount' => 5,
                'discount_type' => 'PERCENTAGE',
            ],
            [
                'name' => 'fixed',
                'discount' => 5,
                'discount_type' => 'fixed',
            ],
        ]);

        $this->command->info('User groups seeded');
    }
}
