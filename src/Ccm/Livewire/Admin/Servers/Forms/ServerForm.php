<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Servers\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Ccm\Models\Server;

class ServerForm extends Form
{
    public Server $server;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public string $name;

    #[Validate]
    public string $type;

    #[Validate]
    public string $ip;

    #[Validate]
    public string $status_url;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'type' => [
                'required',
            ],
            'ip' => [
                'required',
                'ipv4',
            ],
            'status_url' => [
                'url',
            ],
        ];
    }

    public function setServer(Server $server)
    {
        $this->server = $server;
        $this->fill($server->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['server']);

        if ($this->server->id) {
            $this->server->update($data);
        } else {
            $this->server = Server::create($data);
        }

        return $this->server;

    }
}
