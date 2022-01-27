<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('keyword')->nullable(true)->comment('検索キーワード');
            $table->time('start_time_period')->comment('開始時間帯');
            $table->time('end_time_period')->comment('終了時間帯');
            $table->unsignedInteger('max')->default(0)->comment('最大試行回数');
            $table->unsignedInteger('range_min_sleep_time')->default(0)->comment('最低休止時間(s)');
            $table->unsignedInteger('range_max_sleep_time')->default(0)->comment('最大休止時間(s)');
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
        Schema::dropIfExists('options');
    }
}
