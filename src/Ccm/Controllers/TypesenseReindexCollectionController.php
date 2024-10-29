<?php

namespace Sellvation\CCMV2\Ccm\Controllers;

use App\Http\Controllers\Controller;
use Sellvation\CCMV2\Ccm\Jobs\TypesenseReindexCollectionJob;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Orders\Models\Order;

class TypesenseReindexCollectionController extends Controller
{
    public function __invoke(string $collectionName)
    {
        if (\Str::startsWith($collectionName, 'crm_card')) {
            TypesenseReindexCollectionJob::dispatch($collectionName, CrmCard::class);
        } elseif (\Str::startsWith($collectionName, 'order')) {
            TypesenseReindexCollectionJob::dispatch($collectionName, Order::class);
        }

        return redirect()->route('ccm::dashboard');
    }
}
