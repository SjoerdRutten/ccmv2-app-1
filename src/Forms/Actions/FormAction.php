<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Forms\Models\Form;
use Sellvation\CCMV2\Forms\Models\FormResponse;

abstract class FormAction implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Form $form,
        private readonly FormResponse $formResponse) {}

    abstract public function handle(): void;
}
