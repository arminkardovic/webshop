<?php

use Illuminate\Database\Schema\Blueprint;

class OrderItemRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (Schema::hasColumn('order_items', 'meta')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('meta');
            });
        }

    }
}