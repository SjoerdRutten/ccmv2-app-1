<?php

namespace Sellvation\CCMV2\MailServers\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class MailServerForm extends Form
{
    use WithFileUploads;

    public MailServer $mailServer;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public string $host;

    #[Validate]
    public string $private_ip;

    #[Validate]
    public ?string $description = null;

    #[Validate]
    public ?string $port = null;

    #[Validate]
    public ?string $username = null;

    #[Validate]
    public ?string $password = null;

    #[Validate]
    public ?string $encryption = null;

    #[Validate]
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'host' => [
                'required',
            ],
            'private_ip' => [
                'required',
                'ipv4',
            ],
            'port' => [
                'nullable',
            ],
            'username' => [
                'nullable',
            ],
            'password' => [
                'nullable',
            ],
            'encryption' => [
                'nullable',
            ],
            'is_active' => [
                'bool',
            ],
        ];
    }

    public function setMailServer(MailServer $mailServer)
    {
        $this->mailServer = $mailServer;

        $this->fill($mailServer->toArray());

        $this->port = $this->port ?: 25;
        $this->encryption = $this->encryption ?: 'tls';
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['mailServer']);

        if ($this->mailServer->id) {
            $this->mailServer->update($data);
        } else {
            $this->mailServer = MailServer::create($data);
        }

        return $this->mailServer;
    }
}
