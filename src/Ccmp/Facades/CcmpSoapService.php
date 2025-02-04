<?php

namespace Sellvation\CCMV2\Ccmp\Facades;

use RicorocksDigitalAgency\Soap\Facades\Soap;
use Sellvation\CCMV2\Ccmp\Models\LogCcmpAction;
use SoapClient;
use SoapFault;

class CcmpSoapService
{
    public function runAction(int $actionId, $crmId)
    {
        $client = $this->getSoapClient();

        try {
            $result = $client->__soapCall('cmsActionRun', [
                'p_iActionId' => $actionId,
                'p_sCrmId' => $crmId,
            ]);

            LogCcmpAction::create([
                'action_id' => $actionId,
                'crm_id' => $crmId,
                'response' => $result,
                'status' => 1,
            ]);
        } catch (SoapFault $fault) {
            LogCcmpAction::create([
                'action_id' => $actionId,
                'crm_id' => $crmId,
                'response' => $fault->getMessage(),
                'status' => 0,
            ]);
        }
    }

    private function getSoapClient(): SoapClient
    {
        // SOAP-client initialiseren
        $wsdl = config('ccmp.soap_endpoint').'/'.$this->getIdentificationKey();
        $client = new SoapClient($wsdl, [
            'trace' => 1, // Hiermee kun je verzoeken en antwoorden debuggen
            'exceptions' => true,
        ]);

        // Cookie instellen
        $client->__setCookie('identificationkey', $this->getIdentificationKey());

        return $client;
    }

    private function getIdentificationKey()
    {
        return config('ccmp.soap_api_id').'_'.sha1(config('ccmp.soap_api_key'));
    }
}
