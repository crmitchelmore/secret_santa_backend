<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToGiftGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_group', function(Blueprint $table)
          {
            $table->integer('admin_id')->unsigned();
            $table->integer('gift_draw_id')->unsigned();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('gift_group', function ($table) {
            $table->dropColumn('admin_id');
            $table->dropColumn('gift_draw_id');
        });

    }
}
