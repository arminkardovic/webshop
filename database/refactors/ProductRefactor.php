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

        if(\App\Models\Category::where('slug', '=', 'gift-packets')->first() == null) {
            $category = new \App\Models\Category([
                'name'      => 'Gift packets',
                'name_sr'   => 'Poklon paketi',
                'slug'      => 'gift-packets',
                'slug_sr'   => 'poklon-paketi',
                'attribute_set_id' => 1
            ]);
            $category->save();
        }
    }
}