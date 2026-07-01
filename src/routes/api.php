<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:20 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

Route::namespace('v1')->prefix('v1')->middleware('authIf:api')->group(function () {
    Route::apiResource('fundraising_campaigns', 'FundraisingCampaignController', ['as' => 'api']);
    Route::post('fundraising_campaigns/{record}/subscribe', 'FundraisingCampaignController@subscribe')->name('api.fundraising_campaigns.subscribe');
    Route::post('fundraising_campaigns/{record}/unsubscribe', 'FundraisingCampaignController@unsubscribe')->name('api.fundraising_campaigns.unsubscribe');
    Route::post('fundraising_campaigns/{record}/pay', 'FundraisingCampaignController@pay')->name('api.fundraising_campaigns.pay');
    Route::apiResource('fundraising_subscribers', 'FundraisingSubscriberController', ['as' => 'api']);
    Route::apiResource('fundraising_donations', 'FundraisingDonationController', ['as' => 'api']);
});
