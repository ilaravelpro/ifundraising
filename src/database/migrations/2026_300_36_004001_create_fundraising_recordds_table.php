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
        Schema::create('fundraising_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreignId('campaign_id')->nullable()->constrained('fundraising_campaigns');
            $table->foreignId('subscriber_id')->nullable()->constrained('fundraising_subscribers');
            $table->foreignId('donation_id')->nullable()->constrained('fundraising_donations');
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('mobile')->nullable();
            $table->string('national_id')->nullable();
            $table->text('description')->nullable();
            $table->longText('meta')->nullable();
            $table->timestamp('birth_at')->nullable();
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
        Schema::dropIfExists('fundraising_records');
    }
};
