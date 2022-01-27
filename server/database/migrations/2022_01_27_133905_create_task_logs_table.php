<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_logs', function (Blueprint $table) {
            $table->id();
            $table->boolean('result');
            $table->enum('type', ['follow', 'favorite', 'retweet', 'unfollow']);
            $table->unsignedBigInteger('execution_interval')->comment('実行間隔');
            $table->unsignedBigInteger('action_count')->nullable()->comment('総アクション数');
            $table->unsignedBigInteger('success_count')->nullable()->comment('成功アクション数');
            $table->unsignedBigInteger('failed_count')->nullable()->comment('失敗アクション数');
            $table->string('account_id');
            $table->unsignedBigInteger('task_id');
            $table->string('message', 400)->nullable()->comment('メッセージ');
            $table->timestamps();

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_logs');
    }
}
