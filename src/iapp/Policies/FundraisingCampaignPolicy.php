<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 7/21/20, 12:47 PM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iFundraising\iApp\Policies;

use iLaravel\Core\Vendor\iRole\iRolePolicy;

class FundraisingCampaignPolicy extends iRolePolicy
{
    public $prefix = 'fundraising_campaigns';
    public $model = 'FundraisingCampaign';

    public function subscribe($user, $item, ...$args)
    {
        return request()->has("is_me") && request("is_me") == 1 ? !$item->subscribers->where("creator_id", $user->id)->exists() : true;
    }

    public function unsubscribe($user, $item, ...$args)
    {
        return request()->has("is_me") && request("is_me") == 1 ? $item->subscribers->where("creator_id", $user->id)->exists() : true;
    }

    public function pay($user, $item, ...$args)
    {
        return true;
    }
}
