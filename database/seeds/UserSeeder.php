<?php

use App\AdminProfile;
use App\PlayerProfile;
use App\SuperAdminProfile;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('super_admin_profiles')->truncate();
        DB::table('admin_profiles')->truncate();

        /* Super Admin */
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('superadmin'),
        ]);

        $superAdminProfile = SuperAdminProfile::create();

        $superAdminProfile->user()->save($superAdmin);

        /* Admin */
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
        ]);

        $adminProfile = AdminProfile::create();

        $adminProfile->user()->save($admin);

        /* Player */
        $player = User::create([
            'name' => 'Player',
            'username' => 'playerone',
            'email' => 'player@mail.com',
            'password' => Hash::make('player'),
        ]);

        $playerProfile = PlayerProfile::create();

        $playerProfile->user()->save($player);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
