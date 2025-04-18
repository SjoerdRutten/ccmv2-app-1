<?php

namespace Sellvation\CCMV2\CrmCards\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Sellvation\CCMV2\CrmCards\Jobs\UpdateCrmCardFromCcmpJob;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;

class UpdateCrmCardsFromCcmpCommand extends Command
{
    protected $signature = 'crm-cards:update-from-ccmp {--startdate=} {--environment_id=105}';

    protected $description = 'Update CRM Cards from CCMP';

    public function handle(): void
    {
        Config::set('database.connections.db01.database', 'ccmp');
        \DB::purge('db01');

        \Context::add('environment_id', $this->option('environment_id'));

        $this->info('Import CRM Cards');

        if ($this->hasOption('startdate') && $this->option('startdate')) {
            $startDate = Carbon::parse($this->option('startdate'))->toDateTimeString();
        } else {
            $startDate = $this->ask('Wijzigingen vanaf welke datum (YYYY-MM-DD HH:mm:ii) ? ', now()->subDay()->startOfDay()->toDateTimeString());
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
