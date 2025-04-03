<?php

namespace Sellvation\CCMV2\Ccmp\Console\Commands;

use Illuminate\Console\Command;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;

class RemoveCrmCardsFromMongoCommand extends Command
{
    protected $signature = 'remove:crm-cards-from-mongo';

    protected $description = 'Remove CRM Cards from MongoDB which doesn\'t exists anymore in Mysql';

    public function handle(): void
    {
        $environmentId = $this->ask('Welke environment ?');
        \Context::add('environment_id', $environmentId);

        $bar = $this->output->createProgressBar(CrmCardMongo::count());

        $count = 0;
        foreach (CrmCardMongo::cursor() as $crmCardMongo) {
            $bar->advance();

            if (! CrmCard::where('id', '=', $crmCardMongo->id)->exists()) {
                $count++;
                $crmCardMongo->delete();
            }
        }

        $bar->finish();

        $this->info($count.' cards removed from MongoDB');
    }
}
