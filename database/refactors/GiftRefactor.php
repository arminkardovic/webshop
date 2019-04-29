<?php

use Illuminate\Database\Schema\Blueprint;

class GiftRefactor
{
    /**
     * Run the database refactoring.
     *
     * @return void
     */
    public function run()
    {
        /*** DODAVANJE KOLONA **/

        if(!Schema::hasTable('gifts')) {
            Schema::create('gifts', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('from', 250);
                $table->longText('message');
                $table->decimal('value', 13, 2);
                $table->decimal('remaining', 13, 2);
                $table->string('code', 16);
                $table->integer('recipient_id')->unsigned()->nullable()->default(null);

                $table->foreign('recipient_id')
                    ->references('id')->on('users')
                    ->onDelete('no action')
                    ->onUpdate('no action');
            });
        }

    }
}