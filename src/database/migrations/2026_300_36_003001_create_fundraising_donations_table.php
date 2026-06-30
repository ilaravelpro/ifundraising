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
        Schema::create('fundraising_donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreignId('campaign_id')->nullable()->constrained('fundraising_campaigns');
            $table->foreignId('subscriber_id')->nullable()->constrained('fundraising_subscribers');
            $table->foreignId('parent_id')->nullable()->constrained('fundraising_donations');
            $table->foreignId('payment_gateway_id')->nullable()->constrained('payments');
            $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->string('title')->nullable();
            $table->string('number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->double('payment_total',2)->default(0);
            $table->string('currency')->nullable()->default('IRT');
            $table->text('description')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('pending');
            $table->timestamp('payed_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
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
        Schema::dropIfExists('fundraising_donations');
    }
};
