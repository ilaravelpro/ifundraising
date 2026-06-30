<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:18 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

class FundraisingSubscriber extends \iLaravel\Core\iApp\Model
{
    public static $s_prefix = 'IFS';
    public static $s_start = 1155;
    public static $s_end = 18446744073709551615;

    public function creator()
    {
        return $this->belongsTo(imodal('User'), 'creator_id');
    }

    public function bank()
    {
        return $this->belongsTo(imodal('Bank'), 'bank_id');
    }

    public function donations()
    {
        return $this->hasMany(imodal('FundraisingDonation'), 'donation_id');
    }

    public function campaign()
    {
        return $this->belongsTo(imodal('FundraisingCampaign'), 'campaign_id');
    }

    public function rules(Request $request, $action, $parent = null)
    {
        $rules = [];
        switch ($action) {
            case 'store':
            case 'update':
                $rules = array_merge($rules, [
                    'bank_id' => "nullable|exists:banks,id",
                    'campaign_id' => "nullable|exists:fundraising_campaigns,id",
                    'title' => "nullable|string",
                    'duration' => "nullable|string",
                    'duration_value' => "nullable|string",
                    'duration_type' => "nullable|string",
                    'duration_volume' => "nullable|numeric",
                    'duration_amount' => "nullable|numeric",
                    'share_count' => "nullable|numeric",
                    'share_amount' => "nullable|numeric",
                    'current_amount' => "nullable|numeric",
                    'currency' => "nullable|string|in:IRT",
                    'description' => "nullable|string",
                    'started_at' => "nullable",
                    'ended_at' => "nullable",
                    'status' => 'nullable|in:' . join(',', $this->_statuses()),
                ]);
                break;
        }
        return $rules;
    }
}
