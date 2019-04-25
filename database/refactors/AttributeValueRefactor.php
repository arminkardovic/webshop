<?php

use Illuminate\Database\Schema\Blueprint;

class AttributeValueRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (!Schema::hasColumn('attribute_values', 'value_sr')) {
            Schema::table('attribute_values', function (Blueprint $table) {
                $table->string('value_sr', 45)->nullable()->default(null);
            });
        }
    }
}