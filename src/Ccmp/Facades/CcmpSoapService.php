<?php

namespace Sellvation\CCMV2\Ccmp\Facades;

class CcmpSoapService
{
    private function getIdentificationKey()
    {
        return config('ccmp.soap_api_id').'_'.sha1(config('ccmp.soap_api_key'));
    }
}
