<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOnQuestionTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_topic', function (Blueprint $table) {
            $table->foreign('topic_id')
                ->references('id')->on('topics')
                ->onDelete('cascade');
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_topic', function (Blueprint $table) {
            //
        });
    }
}
