<?php

namespace Sellvation\CCMV2\Scheduler\Livewire\Scheduler;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Forms\SchedulerForm;
use Sellvation\CCMV2\Scheduler\Models\ScheduledTask;

class Edit extends Component
{
    use HasModals;
    use WithPagination;

    public ScheduledTask $schedule;

    public SchedulerForm $form;

    public function mount(ScheduledTask $schedule)
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
        return view('scheduler::livewire.scheduler.edit')
            ->with([
                'commands' => \SchedulableCommands::getCommands(),
                'command' => empty($this->form->command) ? false : new ($this->form->command),
                'logs' => $this->schedule->scheduledTaskLogs()->paginate(10),
            ]);
    }
}
