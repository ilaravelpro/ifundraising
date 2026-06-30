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


class FundraisingSubscriberController extends ApiController
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
                'name' => 'creator_id',
                'title' => _t('user'),
                'type' => 'text'
            ],
            [
                'name' => 'bank_id',
                'title' => _t('bank'),
                'type' => 'text'
            ]
        ];
        if ($request->has("is_me") && $request->is_me == 1) {
            $model->where("creator_id", auth()->id());
        }
        return [$filters, [], $operators];
    }
}
