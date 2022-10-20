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
        Schema::create('line_notification_recipients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('line_notification_id')->unsigned();
            $table->bigInteger('recipient_id')->unsigned();
            $table->timestamps();

            $table->foreign('line_notification_id')->references('id')->on('line_notifications');
            $table->foreign('recipient_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('line_notification_recipients')) {
            Schema::table('line_notification_recipients', function(Blueprint $table) {
                $table->dropForeign(['line_notification_id']);
                $table->dropForeign(['recipient_id']);
            });
        }
        Schema::dropIfExists('line_notification_recipients');
    }
};
