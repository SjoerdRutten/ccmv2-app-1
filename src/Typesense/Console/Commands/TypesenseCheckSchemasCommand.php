<?php

namespace Sellvation\CCMV2\Typesense\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Context;
use Sellvation\CCMV2\Typesense\Jobs\CheckSchemaJob;

class TypesenseCheckSchemasCommand extends Command implements Isolatable
{
    protected $signature = 'typesense:check-schemas {--environmentID=105} {--orders} {--products} {--crmcards}';

    protected $description = 'Check schema';

    public function handle(): void
    {
        $environmentId = $this->ask('Environment ID: ', $this->option('environmentID'));
        Context::add('environment_id', $environmentId);

        if ($this->confirm('Update orders index ?', $this->option('orders'))) {
            CheckSchemaJob::dispatch('Order');
        } elseif ($this->confirm('Update products index ?', $this->option('products'))) {
            CheckSchemaJob::dispatch('Product');
        } elseif ($this->confirm('Update crm-cards index ?', $this->option('crmcards'))) {
            CheckSchemaJob::dispatch('CrmCard');
        }
    }
}
