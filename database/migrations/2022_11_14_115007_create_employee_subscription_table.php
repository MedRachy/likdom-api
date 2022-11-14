<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_subscription', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id')->references('id')
                ->on('subscriptions');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')
                ->on('employees');
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
        Schema::dropIfExists('employee_subscription');
    }
}
