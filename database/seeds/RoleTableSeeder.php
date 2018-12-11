<?php

use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;

class RoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
            ],
            [
                'name' => 'User',
                'slug' => 'user',
            ],
        ]);

        $this->command->info('Roles seeded');
    }
}
