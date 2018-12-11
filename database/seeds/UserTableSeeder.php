<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    use \Database\DisableForeignKeys;

    public function run()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $moderatorRole = Role::where('slug', 'moderator')->first();
        $userRole = Role::where('slug', 'user')->first();

        $this->disableForeignKeys();
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'full_name' => config('site.admin_name'),
                'email' => config('site.admin_email'),
                'password' => bcrypt('123456'),
                'email_verified' => true,
                'email_verified_at' => now(),
                'role_id' => $adminRole->id,
            ],
            [
                'full_name' => 'Moderator',
                'email' => 'moderator@ronypony.com',
                'password' => bcrypt('123456'),
                'email_verified' => true,
                'email_verified_at' => now(),
                'role_id' => $moderatorRole->id,
            ],
            [
                'full_name' => 'Nageswara Rao S',
                'email' => 'nag.samayam@gmail.com',
                'password' => bcrypt('123456'),
                'email_verified' => true,
                'email_verified_at' => now(),
                'role_id' => $userRole->id,
            ],
        ]);

        $this->command->info('Users seeded');
    }
}