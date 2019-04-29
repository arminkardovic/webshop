<?php

use Illuminate\Database\Schema\Blueprint;

class OrderRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (!Schema::hasColumn('orders', 'meta')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->json('meta')->nullable();
            });
        }

        if (!Schema::hasColumn('orders', 'reclamation')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->longText('reclamation')->nullable()->default(null);
            });
        }

    }
}