<?php

namespace Sellvation\CCMV2\Scheduler\Livewire\Scheduler;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Forms\SchedulerForm;
use Sellvation\CCMV2\Scheduler\Models\Schedule;

class Edit extends Component
{
    use HasModals;

    public Schedule $schedule;

    public SchedulerForm $form;

    public function mount(Schedule $schedule)
    {
        $this->schedule = $schedule;
        $this->form->setModel($this->schedule);
    }

    public function save()
    {
        $this->schedule = $this->form->save();

        $this->showSuccessModal(title: 'Taak is opgeslagen', href: route('admin::scheduler::edit', $this->schedule->id));
    }

    public function render()
    {
        dd(\Artisan::all());

        return view('scheduler::livewire.scheduler.edit')
            ->with([
            ]);
    }
}
