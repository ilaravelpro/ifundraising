<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:29 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

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
        Schema::create('fundraising_subscribers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('campaign_id')->nullable()->constrained('fundraising_campaigns');
            $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->string('title')->nullable();
            $table->string('duration')->nullable();
            $table->integer('duration_value')->nullable();
            $table->string('duration_type')->nullable();
            $table->double('duration_volume', 2)->nullable();
            $table->double('duration_amount', 2)->nullable();
            $table->bigInteger('bond_count')->nullable();
            $table->double('bond_amount', 2)->nullable();
            $table->double('current_amount', 2)->nullable();
            $table->string('currency')->nullable()->default('IRT');
            $table->string('status')->default('active');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
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
        Schema::dropIfExists('fundraising_subscribers');
    }
};
