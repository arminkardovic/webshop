<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->delete();

        $addresses = [
            [
                'user_id' => 2,
                'country_id' => 178,
                'name' => 'Armin Kardovic',
                'address1' => 'Mustafa Pecanin',
                'address2' => 'No. 34',
                'county' => 'Montenegro',
                'city' => 'Podgorica',
                'postal_code' => '81000',
                'phone' => '+38267001087',
                'mobile_phone' => '+38267001087',
                'comment' => 'Lorem ipsum dolor sit amet.',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()

            ],
        ];

        DB::table('addresses')->insert($addresses);
    }
}
