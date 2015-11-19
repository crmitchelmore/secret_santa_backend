<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToGiftDraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('gift_draw', function(Blueprint $table)
          {
            $table->integer('gift_group_id')->unsigned();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('gift_draw', function ($table) {
            $table->dropColumn('gift_group_id');
        });

    }
}
