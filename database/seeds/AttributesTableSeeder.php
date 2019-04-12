<?php

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('attributes')->delete();

    	$attributes = [
    		[
				'id'   => 1,
				'type' => 'dropdown',
				'name' => 'Color',
    		],
    		[
				'id'   => 2,
				'type' => 'dropdown',
				'name' => 'Size',
    		],
            [
                'id'   => 3,
                'type' => 'dropdown',
                'name' => 'Fit',
            ]
    	];

    	DB::table('attributes')->insert($attributes);
    }
}
