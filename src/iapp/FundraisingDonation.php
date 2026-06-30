<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:18 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

class FundraisingDonation extends \iLaravel\Core\iApp\Model
{
    public static $s_prefix = 'IFD';
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

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function kids()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(imodal('FundraisingSubscriber'), 'subscriber_id');
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
                    'subscriber_id' => "nullable|exists:fundraising_subscribers,id",
                    'parent_id' => "nullable|exists:fundraising_donations,id",
                    'title' => "nullable|string",
                    'invoice_number' => "invoice_number|string",
                    'payment_total' => "nullable|numeric",
                    'currency' => "nullable|string|in:IRT",
                    'description' => "nullable|string",
                    'payed_at' => "nullable",
                    'confirmed_at' => "nullable",
                    'status' => 'nullable|in:' . join(',', $this->_statuses()),
                ]);
                break;
        }
        return $rules;
    }
}
