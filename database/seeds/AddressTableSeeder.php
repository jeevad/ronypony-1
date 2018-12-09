<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    use \Database\DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('slug', 'user')->first();
        if ($userRole) {
            $this->disableForeignKeys();
            DB::table('addresses')->truncate();
            $user = User::where('role_id', $userRole->id)->first();

            factory('App\Models\Address', 1)
                ->states('default')
                ->create(
                    [
                        'user_id' => $user->id,
                        'state_id' => 1,
                        'country_id' => 1
                    ]);

            factory('App\Models\Address', 3)
                ->create(
                    [
                        'user_id' => $user->id,
                        'state_id' => 1,
                        'country_id' => 1
                    ]);

            $this->command->info('Addresses seeded');
        }
    }
}
