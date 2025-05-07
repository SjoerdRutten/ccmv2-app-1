<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Servers;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Servers\Forms\ServerForm;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Ccm\Models\Server;

class Edit extends Component
{
    use HasModals;

    public Server $server;

    public ServerForm $form;

    public function mount(Server $server)
    {
        $this->server = $server;
        $this->form->setServer($this->server);
    }

    public function save()
    {
        $this->server = $this->form->save();

        $this->showSuccessModal('Server is opgeslagen', href: route('admin::servers::edit', $this->server->id));
    }

    public function render()
    {
        return view('ccm::livewire.admin.servers.edit');
    }
}
