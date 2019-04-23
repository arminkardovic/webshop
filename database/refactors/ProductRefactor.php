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

        if (!Schema::hasColumn('products', 'gift')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('gift')->default(0);
            });
        }


        if (Schema::hasColumn('products', 'attribute_set_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('attribute_set_id')->unsigned()->nullable()->default(null)->change();
            });
        }
    }
}