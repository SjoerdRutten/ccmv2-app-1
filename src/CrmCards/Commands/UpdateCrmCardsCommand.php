<?php

namespace Sellvation\CCMV2\CrmCards\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Sellvation\CCMV2\CrmCards\Jobs\UpdateCrmCardFromCcmpJob;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;

class UpdateCrmCardsCommand extends Command
{
    protected $signature = 'crm-cards:update-from-ccmp {--startdate} {--environment_id=}';

    protected $description = 'Update CRM Cards from CCMP';

    public function handle(): void
    {
        $this->info('Import CRM Cards');

        if ($this->hasOption('startdate')) {
            $startDate = Carbon::parse($this->option('startdate'))->toDateTimeString();
        } else {
            $startDate = $this->ask('Wijzigingen vanaf welke datum (YYYY-MM-DD HH:mm:ii) ? ', now()->subMinutes(70)->toDateTimeString());
        }

        $query = \DB::connection('db01')
            ->table('crm_'.$this->option('environment_id'))
            ->select('crmid')
            ->where('datummutatie', '>=', $startDate)
            ->orderBy('datummutatie');

        $progressBar = $this->output->createProgressBar($query->count());

        $query->chunk(500, function ($crmCards) use ($progressBar) {
            foreach ($crmCards as $key => $row) {
                $progressBar->advance();

                UpdateCrmCardFromCcmpJob::dispatch($row->crmid);
            }
        });

        $progressBar->finish();

        $this->removeCrmCards();
    }

    private function removeCrmCards()
    {
        $this->info('Remove CRM Card which don\'t exists anymore at CCMP.');

        $total = CrmCard::count();
        $bar = $this->output->createProgressBar($total);

        $deleted = 0;
        foreach (CrmCard::select(['id', 'crm_id'])->cursor() as $crmCard) {
            if (! \DB::connection('db01')
                ->table('crm_'.$this->option('environment_id'))
                ->where('crmid', $crmCard->crm_id)
                ->exists()) {
                $crmCard->delete();
                $deleted++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->output->text($deleted.' of '.$total.' CRM Cards were removed.');

        $total = CrmCardMongo::count();
        $bar = $this->output->createProgressBar($total);

        $deleted = 0;
        foreach (CrmCardMongo::select(['id', 'crm_id'])->cursor() as $crmCard) {
            if (! CrmCard::find($crmCard->id)) {
                $crmCard->delete();
                $deleted++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->output->text($deleted.' of '.$total.' CRM Cards were removed.');
    }
}
