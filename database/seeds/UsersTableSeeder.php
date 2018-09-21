<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'Dima Maimesko';
        $admin->email = 'dima.maimesko@gmail.com';
        $admin->email_verified_at = now();
        $admin->password = bcrypt('123456');
        $admin->remember_token = str_random(10);
        $admin->verify_token = str_random(16);
        $admin->status = USER::STATUS_ACTIVE;
        $admin->save();
        $admin->assignRole(User::SUPERADMIN);
        factory(User::class, 10)->create();
        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole(User::USER);
        }
    }
}
