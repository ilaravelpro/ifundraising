<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:18 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

class FundraisingRecord extends \iLaravel\Core\iApp\Model
{
    public static $s_prefix = 'IFR';
    public static $s_start = 1155;
    public static $s_end = 18446744073709551615;

    public $casts = [
       "meta" => "array",
    ];

    public $with_resource_data = ["subscriber", "donation", "campaign"];

    public function creator()
    {
        return $this->belongsTo(imodal('User'), 'creator_id');
    }
    public function subscriber()
    {
        return $this->belongsTo(imodal('FundraisingSubscriber'), 'subscriber_id');
    }

    public function campaign()
    {
        return $this->belongsTo(imodal('FundraisingCampaign'), 'campaign_id');
    }

    public function donation()
    {
        return $this->belongsTo(imodal('FundraisingDonation'), 'donation_id');
    }

    public function rules(Request $request, $action, $parent = null)
    {
        $rules = [];
        switch ($action) {
            case 'store':
            case 'update':
                $rules = array_merge($rules, [
                    'campaign_id' => "required|exists:fundraising_campaigns,id",
                    'subscriber_id' => "required|exists:fundraising_subscribers,id",
                    'donation_id' => "required|exists:fundraising_donations,id",
                    'name' => "nullable|string",
                    'family' => "nullable|string",
                    'gender' => "nullable|string|in:male,female",
                    'mobile' => "nullable|string",
                    'national_id' => "nullable|string",
                    'description' => "nullable|string",
                    'meta.*' => "nullable|string",
                    'birth_at' => "nullable|string",
                ]);
                break;
        }
        return $rules;
    }
}
