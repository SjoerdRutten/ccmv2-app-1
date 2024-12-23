<?php

namespace Sellvation\CCMV2\MailServers\Livewire\SendRules;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\MailServers\Livewire\SendRules\Forms\SendRuleForm;
use Sellvation\CCMV2\MailServers\Models\SendRule;

class Edit extends Component
{
    use HasModals;

    public SendRule $sendRule;

    public SendRuleForm $form;

    public function mount(SendRule $sendRule)
    {
        $this->sendRule = $sendRule;
        $this->form->setSendRule($this->sendRule);
    }

    public function save()
    {
        $this->sendRule = $this->form->save();

        $this->showSuccessModal(title: 'Verzendregel is opgeslagen', href: route('admin::sendrules::edit', $this->sendRule->id));
    }

    public function render()
    {
        return view('mailservers::livewire.send-rules.edit')
            ->with([
            ]);
    }
}
