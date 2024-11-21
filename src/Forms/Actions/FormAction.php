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

    /**
     * @var bool
     *           Set to true if this action should be executed for all forms
     */
    public bool $alwaysExecute = false;

    /**
     * @var string
     *             The name of the action, how it will appear in the system
     */
    public string $name = '';

    public function __construct(
        protected ?Form $form = null,
        protected ?FormResponse $formResponse = null,
        protected array $params = [],
    ) {}

    /**
     * @return void
     *              Execute the action
     */
    abstract public function handle(): void;

    /**
     * @return View|null
     *                   Return a view with the config form for the action, or null of no
     *                   params are necessary
     */
    abstract public function form(): ?View;

    /**
     * @return $this
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return $this
     */
    public function setFormResponse(FormResponse $formResponse): self
    {
        $this->formResponse = $formResponse;

        return $this;
    }
}
