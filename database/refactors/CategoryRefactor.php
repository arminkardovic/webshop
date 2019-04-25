<?php

use Illuminate\Database\Schema\Blueprint;

class CategoryRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (!Schema::hasColumn('categories', 'name_sr')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('name_sr', 100)->nullable()->default(null);
            });
        }

        if (!Schema::hasColumn('categories', 'slug_sr')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('slug_sr', 100)->nullable()->default(null);
            });
        }

    }
}