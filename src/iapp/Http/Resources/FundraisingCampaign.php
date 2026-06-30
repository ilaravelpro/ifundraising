<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/15/20, 1:10 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class FundraisingCampaign extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        if (isset($data['status'])) $data['status_text'] = _t($data["status"]);
        return $data;
    }
}
