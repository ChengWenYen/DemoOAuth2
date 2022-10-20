<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_notifications', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->bigInteger('sender_id')->unsigned();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('line_notifications')) {
            Schema::table('line_notifications', function(Blueprint $table) {
                $table->dropForeign(['sender_id']);
            });
        }
        Schema::dropIfExists('line_notifications');
    }
};
