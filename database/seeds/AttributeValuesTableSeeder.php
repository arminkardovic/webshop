<?php

use Illuminate\Database\Seeder;

class AttributeValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('attribute_values')->delete();

    	$attributeValues = [
    		[
				'attribute_id' => 1,
				'value'        => 'Black',
    		],
    		[
				'attribute_id' => 1,
				'value'        => 'White',
    		],
    		[
				'attribute_id' => 1,
				'value'        => 'Blue',
    		],
    		[
				'attribute_id' => 1,
				'value'        => 'Red',
    		],
    		[
				'attribute_id' => 2,
				'value'        => 'S',
    		],
    		[
				'attribute_id' => 2,
				'value'        => 'M',
    		],
    		[
				'attribute_id' => 2,
				'value'        => 'L',
    		],
    		[
				'attribute_id' => 2,
				'value'        => 'XL',
    		],
            [
                'attribute_id' => 3,
                'value'        => 'SLIM',
            ],
            [
                'attribute_id' => 3,
                'value'        => 'COMFORT',
            ],
    	];

    	DB::table('attribute_values')->insert($attributeValues);
    }
}
