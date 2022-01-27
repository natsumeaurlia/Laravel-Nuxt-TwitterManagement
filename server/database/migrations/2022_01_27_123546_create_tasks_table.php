<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->nullable()->comment('検索キーワード');
            $table->string('name');
            $table->string('account_id');
            $table->enum('type', ['follow', 'favorite', 'retweet', 'unfollow'])->index();
            $table->unsignedMediumInteger('execution_interval')->comment('実行間隔');
            $table->time('start_time_period')->index()->comment('開始時間帯');
            $table->time('end_time_period')->index()->comment('終了時間帯');
            $table->unsignedInteger('max_execution')->default(0)->comment('最大試行回数');
            $table->unsignedInteger('range_min_sleep_time')->default(0)->comment('最低休止時間(s)');
            $table->unsignedInteger('range_max_sleep_time')->default(0)->comment('最大休止時間(s)');
            $table->boolean('is_enable')->default(true)->index()->comment('有効かどうか');
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
        Schema::dropIfExists('tasks');
    }
}
