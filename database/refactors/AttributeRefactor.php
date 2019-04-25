<?php

use Illuminate\Database\Schema\Blueprint;

class AttributeRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (!Schema::hasColumn('attributes', 'name_sr')) {
            Schema::table('attributes', function (Blueprint $table) {
                $table->string('name_sr', 100)->nullable()->default(null);
            });
        }
    }
}