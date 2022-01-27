<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transitions', function (Blueprint $table) {
            $table->id();
            $table->string('account_id');
            $table->unsignedBigInteger('follower')->default(0)->comment('フォロワー数');
            $table->unsignedBigInteger('follow')->default(0)->comment('フォロー数');
            $table->unsignedBigInteger('favourite')->default(0)->comment('いいね数');
            $table->unsignedBigInteger('tweet')->default(0)->comment('ツイート数');
            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transitions');
    }
}
