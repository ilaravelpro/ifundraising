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
            } else {
                $subscribe = $item->subscribers()->updateOrCreate([
                    "creator_id" => auth()->id(),
                    "duration" => $item->duration,
                    "duration_value" => $item->duration_value,
                    "duration_type" => $item->duration_type,
                    "duration_volume" => $item->duration_volume,
                    "duration_amount" => $item->duration_amount,
                    "bond_amount" => $item->bond_amount,
                    "bond_count" => $request->bound_count ?: 1,
                ]);
                $data_record = [
                    "name" => @$request->name,
                    "family" => @$request->family,
                    "gender" => @$request->gender,
                    "mobile" => @$request->mobile,
                    "national_id" => @$request->national_id,
                    "description" => @$request->description,
                    "meta" => !empty($request->meta) && is_array($request->meta) ? @$request->meta : null,
                ];
                if (!empty($data_record = array_filter($data_record, fn($v) => !empty($v)))) {
                    $subscribe->record()->updateOrCreate(["campaign_id" => $item->id], $data_record);
                    if ($item->is_registering) {
                        $userModel = imodal("User");
                        if ($user = $userModel->where("national_id")->first()) {
                            foreach (["name", "family","gender", "mobile", "national_id"] as $index_name)
                                if (!empty($data_record[$index_name]))$user->$index_name = $data_record[$index_name];
                            $user->save();
                        }else {
                            $user = $userModel->updateOrCreate(["national_id" => $item->national_id], [
                                "name" => @$data_record["name"],
                                "family" => @$data_record["family"],
                                "gender" => @$data_record["gender"],
                                "mobile" => @$data_record["mobile"],
                                "national_id" => @$data_record["national_id"],
                            ]);
                        }
                        $subscribe->user_id = $user->id;
                    }
                }
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
