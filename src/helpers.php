<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:18 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

function ifundraising_path($path = null)
{
    $path = trim($path, '/');
    return __DIR__ . ($path ? "/$path" : '');
}

function ifundraising($key = null, $default = null)
{
    return iconfig('ifundraising' . ($key ? ".$key" : ''), $default);
}
