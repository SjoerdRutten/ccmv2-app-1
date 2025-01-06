<?php

namespace Sellvation\CCMV2\Ems\Livewire\Emails;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Ems\Livewire\Emails\Forms\EmailForm;
use Sellvation\CCMV2\Ems\Models\Email;

class Edit extends Component
{
    use HasModals;

    public Email $email;

    public EmailForm $form;

    public string $stripoToken;

    public function mount()
    {
        $this->form->setEmail($this->email);

        $response = Http::asJson()
            ->post('https://plugins.stripo.email/api/v1/auth', [
                'pluginId' => config('stripo.plugin_id'),
                'secretKey' => config('stripo.secret_key'),
            ]);

        if ($response->ok()) {
            $this->stripoToken = $response->json('token');
        }
    }

    public function updated($property, $value)
    {
        switch ($property) {
            case 'form.recipient_type':
                $this->form->recipient = null;
                $this->form->recipient_crm_field_id = null;
                break;
        }
    }

    public function save()
    {
        $this->email = $this->form->save();

        $this->showSuccessModal(title: 'E-mail is opgeslagen', href: route('ems::emails::edit', $this->email));
    }

    public function render()
    {
        return view('ems::livewire.emails.edit');
    }
}
