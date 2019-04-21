<?php
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
        /*** DODAVANJE KOLONA **/
        /*
        if (!Schema::hasColumn('users', 'mobile_phone')) {
            Schema::table('users', function ($table) {
                $table->string('mobile_phone')->after('cp_ext')->nullable();
            });
        }
        */
    }
}