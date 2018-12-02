<?php 

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
  public function run()
  {
    $role_employee = Role::where('name', 'admin')->first();
    $role_manager  = Role::where('name', 'manager')->first();

    $employee = new User();
    $employee->name = 'Employee Name';
    $employee->email = 'jeeva.jccd@gmail.com';
    $employee->password = bcrypt('12345678');
    $employee->save();
    $employee->roles()->attach($role_employee);

    $manager = new User();
    $manager->name = 'Manager Name';
    $manager->email = 'manager@example.com';
    $manager->password = bcrypt('12345678');
    $manager->save();
    $manager->roles()->attach($role_manager);
  }
}