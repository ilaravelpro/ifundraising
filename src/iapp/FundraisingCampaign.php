<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:18 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

class FundraisingCampaign extends \iLaravel\Core\iApp\Model
{
    public static $s_prefix = 'IFC';
    public static $s_start = 1155;
    public static $s_end = 18446744073709551615;
    public $files = ['image'];

    public $set_slug = true;

    public $with_resource_data = ["user", "bank", "parent"];
    public $with_resource_smart = ["record"];

    public static $find_names = ["slug"];

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

    public function subscribers()
    {
        return $this->hasMany(imodal('FundraisingSubscriber'), 'campaign_id');
    }

    public function donations()
    {
        return $this->hasMany(imodal('FundraisingDonation'), 'campaign_id');
    }

    public function record()
    {
        return $this->belongsTo(imodal('FundraisingRecord'), 'record_id')->whereNull("subscriber_id");
    }
    public function records()
    {
        return $this->hasMany(imodal('FundraisingRecord'), 'record_id')->whereNotNull("subscriber_id");
    }

    public function rules(Request $request, $action, $arg1 = null)
    {
        $rules = [];
        $additionalRules = [
            'image_file' => 'nullable|mimes:jpeg,jpg,png,gif|max:5120',
        ];
        switch ($action) {
            case 'store':
            case 'update':
                $rules = array_merge($rules, [
                    'bank_id' => "nullable|exists:banks,id",
                    'parent_id' => "nullable|exists:fundraising_campaigns,id",
                    'title' => "required|string",
                    'type' => "nullable|string",
                    'duration' => "nullable|string",
                    'duration_value' => "nullable|string",
                    'duration_type' => "nullable|string",
                    'duration_volume' => "nullable|numeric",
                    'duration_amount' => "nullable|numeric",
                    'bond_min' => "nullable|numeric",
                    'bond_amount' => "nullable|numeric",
                    'goal_amount' => "nullable|numeric",
                    'current_amount' => "nullable|numeric",
                    'currency' => "nullable|string|in:IRT",
                    'description' => "nullable|string",
                    'template' => "nullable|string",
                    'content' => "nullable|string",
                    'is_global' => "nullable|boolean",
                    'is_registering' => "nullable|boolean",
                    'started_at' => "nullable",
                    'ended_at' => "nullable",
                    'status' => 'nullable|in:' . join(',', $this->_statuses()),
                ],$additionalRules);
                break;
            case 'subscribe':
                $arg1 = is_string($arg1) ? $this::findByAny($arg1) : $arg1;
                if ($arg1->type == "bond") {
                    $rules = [
                        'bond_count' => "required|numeric|min:" . ($arg1->bond_min?:1),
                    ];
                }
                $rules = array_merge($rules, [
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

    public function additionalUpdate($request = null, $additional = null, $parent = null)
    {
        parent::additionalUpdate($request, $additional, $parent);
    }
}
