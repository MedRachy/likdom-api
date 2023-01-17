<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users');
            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id')->references('id')
                ->on('subscriptions');
            $table->string('manager_name');
            $table->string('cin_number')->nullable();
            $table->string('company_name');
            $table->string('adress');
            $table->string('city');
            $table->string('rc_number');
            $table->string('capital');
            $table->string('storage_path')->nullable();
            $table->string('status')->nullable()->default('pending');
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
        Schema::dropIfExists('contracts');
    }
}
