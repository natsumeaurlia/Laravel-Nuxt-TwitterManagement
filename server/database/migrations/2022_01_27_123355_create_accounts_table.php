<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('id')->primary()->comment('twitter user id');
            $table->string('name', 50)->comment('アカウント名');
            $table->string('screen_name', 50)->comment('表示名');
            $table->string('avatar_path', 1000);
            $table->string('access_token', 1000)->nullable();
            $table->string('access_token_secret', 1000)->nullable();
            $table->string('api_key', 1000)->nullable();
            $table->string('api_secret_key', 1000)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
