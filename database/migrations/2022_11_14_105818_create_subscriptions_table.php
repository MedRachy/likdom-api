<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreign('offer_id')->references('id')
                ->on('offers');

            $table->string('service')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('passages')->nullable();

            $table->time('nbr_hours', $precision = 0)->nullable();
            $table->smallInteger('nbr_employees')->nullable();
            $table->json('location')->nullable();
            $table->boolean('products')->nullable()->default(false);
            $table->boolean('confirmed')->nullable()->default(false);
            $table->string('status')->nullable()->default('pending');
            $table->float('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
