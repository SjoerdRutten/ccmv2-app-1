<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
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

    public bool $alwaysExecute = false;

    public string $name = '';

    public function __construct(
        protected ?Form $form = null,
        protected ?FormResponse $formResponse = null,
        protected array $params = [],
    ) {}

    abstract public function handle(): void;

    abstract public function form(): ?View;

    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function setFormResponse(FormResponse $formResponse): self
    {
        $this->formResponse = $formResponse;

        return $this;
    }
}
