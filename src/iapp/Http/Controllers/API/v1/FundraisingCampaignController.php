<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:32 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp\Http\Controllers\API\v1;

use Carbon\Carbon;
use iLaravel\Core\iApp\Exceptions\iException;
use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;
use iLaravel\Core\iApp\Http\Controllers\API\ApiController;


class FundraisingCampaignController extends ApiController
{
    public $statusFilter = false;

    public function filters($request, $model, $parent = null, $operators = [])
    {
        $filters = [
            [
                'name' => 'all',
                'title' => _t('all'),
                'type' => 'text',
            ],
            [
                'name' => 'title',
                'title' => _t('title'),
                'type' => 'text'
            ],
            [
                'name' => 'description',
                'title' => _t('description'),
                'type' => 'text'
            ],
            [
                'name' => 'bank_id',
                'title' => _t('bank'),
                'type' => 'text'
            ]
        ];
        return [$filters, [], $operators];
    }


    public function subscribe(Request $request, $record)
    {
        if ($item = $this->model::findBySerial($record)) {
            if ($subscribe = $item->subscribers()->where("creator_id", auth()->id())->first()) {
                $subscribe->update(['status' => "canceled", "canceled_at" => Carbon::now()]);
                $this->statusMessage = _t("Your subscription was successfully canceled.");
            }else {
                $item->subscribers()->updateOrCreate([
                    "creator_id" => auth()->id(),
                    "duration" => $item->duration,
                    "duration_value" => $item->duration_value,
                    "duration_type" => $item->duration_type,
                    "duration_volume" => $item->duration_volume,
                    "duration_amount" => $item->duration_amount,
                    "bond_amount" => $item->bond_amount,
                    "bond_count" => $request->bound_count?:1,
                ]);
                $this->statusMessage = _t("Your subscription was successful.");
            }
        }
        return $this->_show($request, $item);
    }


    public function unsubscribe(Request $request, $record)
    {
        if ($item = $this->model::findBySerial($record)) {
            if ($subscribe = $item->subscribers()->where("creator_id", auth()->id())->first()) {
                $subscribe->update(['status' => "canceled", "canceled_at" => Carbon::now()]);
            }
            $this->statusMessage = _t("Your subscription was successfully canceled.");
        }
        return $this->_show($request, $item);
    }
}
