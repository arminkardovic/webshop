<?php

use Illuminate\Database\Seeder;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('taxes')->delete();

    	$taxes = [
    		[
				'name'  => 'POREZ 0%',
				'value' => '0',
    		],
    	];

    	DB::table('taxes')->insert($taxes);
    }
}
