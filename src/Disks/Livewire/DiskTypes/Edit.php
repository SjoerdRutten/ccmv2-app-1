<?php

namespace Sellvation\CCMV2\Disks\Livewire\DiskTypes;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Disks\Livewire\DiskTypes\Forms\DiskTypeForm;
use Sellvation\CCMV2\Disks\Models\Disk;
use Sellvation\CCMV2\Disks\Models\DiskType;

class Edit extends Component
{
    use HasModals;
    use WithPagination;

    public DiskType $diskType;

    public DiskTypeForm $form;

    public function mount(DiskType $diskType)
    {
        $this->diskType = $diskType;
        $this->form->setModel($this->diskType);
    }

    public function save()
    {
        $this->diskType = $this->form->save();

        $this->showSuccessModal(title: 'Disktype is opgeslagen', href: route('admin::disktypes::edit', $this->diskType->id));
    }

    public function render()
    {
        return view('disks::disktypes.edit')
            ->with([
                'disks' => Disk::orderBy('name')->get(),
            ]);
    }
}
