<?php

namespace Sellvation\CCMV2\Ems\Livewire\Mailings;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Ems\Livewire\Mailings\Forms\MailingForm;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailMailing;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Edit extends Component
{
    use HasModals;

    public EmailMailing $emailMailing;

    public MailingForm $form;

    public int $targetGroupCount;

    public function mount(EmailMailing $emailMailing)
    {
        $this->emailMailing = $emailMailing;
        $this->countTargetGroup($emailMailing->target_group_id);

        $this->form->setMailing($this->emailMailing);
    }

    public function updated($property, $value)
    {
        if ($property == 'form.target_group_id') {
            $this->countTargetGroup($value);
        }
    }

    private function countTargetGroup(?int $targetGroupId)
    {
        if ($targetGroup = TargetGroup::find($targetGroupId)) {
            $this->targetGroupCount = $targetGroup->number_of_results;
        }
    }

    public function save()
    {
        $this->emailMailing = $this->form->save();

        $this->showSuccessModal(title: 'Mailing is opgeslagen', href: route('ems::mailings::edit', $this->emailMailing));
    }

    public function render()
    {
        return view('ems::livewire.mailings.edit')
            ->with([
                'emails' => Email::query()->orderBy('name')->get(),
                'targetGroups' => TargetGroup::orderBy('name')->get(),
            ]);
    }
}
