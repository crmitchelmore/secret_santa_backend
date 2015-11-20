<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PluralizeTableNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('user', 'users');
        Schema::rename('gift_group', 'gift_groups');
        Schema::rename('gift_draw', 'gift_draws');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('users', 'user');
        Schema::rename('gift_groups', 'gift_group');
        Schema::rename('gift_draws', 'gift_draw');
    }
}
