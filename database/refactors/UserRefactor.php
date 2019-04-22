<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 21.4.2019.
 * Time: 11:35
 */


class UserRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {

        if (!Schema::hasColumn('users', 'location_settings_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('location_settings_id')->unsigned()->nullable();
                $table->foreign('location_settings_id')
                    ->references('id')->on('location_settings')
                    ->onDelete('no action')
                    ->onUpdate('no action');
            });
        }

    }
}