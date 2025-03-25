<?php

namespace Sellvation\CCMV2\Disks\Livewire\Disks;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Disks\Livewire\Disks\Forms\DiskForm;
use Sellvation\CCMV2\Disks\Models\Disk;

class Edit extends Component
{
    use HasModals;
    use WithPagination;

    public Disk $disk;

    public DiskForm $form;

    public function mount(Disk $disk)
    {
        $this->disk = $disk;
        $this->form->setModel($this->disk);
    }

    public function save()
    {
        $this->disk = $this->form->save();

        $this->showSuccessModal(title: 'Disk is opgeslagen', href: route('admin::disks::edit', $this->disk->id));
    }

    public function render()
    {
        return view('disks::disks.edit')
            ->with([
            ]);
    }
}
