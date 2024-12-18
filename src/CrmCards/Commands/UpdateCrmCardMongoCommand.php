<?php

namespace Sellvation\CCMV2\CrmCards\Commands;

use Illuminate\Console\Command;
use Sellvation\CCMV2\CrmCards\Jobs\UpdateCrmCardMongoDbJob;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class UpdateCrmCardMongoCommand extends Command
{
    protected $signature = 'update:crm-card-mongo';

    protected $description = 'Update CRM Cards in MongoDB';

    public function handle(): void
    {
        $total = CrmCard::count();
        $perPage = 5000;

        $progressBar = $this->output->createProgressBar($total);

        for ($i = 0; $i < ceil($total / $perPage); $i++) {
            foreach (CrmCard::limit($perPage)->skip($i * $perPage)->get() as $crmCard) {
                $progressBar->advance();
                UpdateCrmCardMongoDbJob::dispatch($crmCard);
            }
        }

        $progressBar->finish();
    }
}
