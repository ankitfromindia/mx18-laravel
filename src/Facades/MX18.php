<?php

namespace AnkitFromIndia\MX18\Facades;

use Illuminate\Support\Facades\Facade;
use AnkitFromIndia\MX18\Http\MX18Client;

class MX18 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MX18Client::class;
    }
}
