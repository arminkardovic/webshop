<?php

use Illuminate\Database\Schema\Blueprint;

class ProductRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (Schema::hasColumn('products', 'subcategory_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('subcategory_id')->unsigned()->nullable()->change();
            });
        }

    }
}