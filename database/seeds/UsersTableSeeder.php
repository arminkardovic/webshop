<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$ViW0rhHAu4yf/Z9qG94zSuOyLiqewAv04jxYvGqYpOWTicOsssoEi', // Encrypted password is: adminpass
                'salutation' => 'Gospodin.',
                'birthday' => \Carbon\Carbon::now()->toDateString(),
                'gender' => 1,
                'active' => 1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
            // Client
            [
                'name' => 'Client',
                'email' => 'client@gmail.com',
                'password' => '$2y$10$xxgI.2pRrN1H6LuxYJz.0.653AyqU4E1302xe.N4MOhv3uHM0Uqo2', // Encrypted password is: clientpass
                'salutation' => 'Gospođa.',
                'birthday' => \Carbon\Carbon::now()->subYears(20)->toDateString(),
                'gender' => 1,
                'active' => 1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ],
        ];

        DB::table('users')->insert($users);
    }
}
