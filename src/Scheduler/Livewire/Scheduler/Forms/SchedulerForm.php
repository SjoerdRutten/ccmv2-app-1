<?php

namespace Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Scheduler\Models\Schedule;

class SchedulerForm extends Form
{
    use WithFileUploads;

    public Schedule $schedule;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public string $name;

    #[Validate]
    public ?string $description = null;

    #[Validate]
    public bool $is_active = true;

    #[Validate]
    public string $type = '';

    #[Validate]
    public string $command = '';

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'is_active' => [
                'bool',
            ],
            'type' => [
                'required',
            ],
            'command' => [
                'required',
            ],
        ];
    }

    public function setModel(Schedule $schedule)
    {
        $this->schedule = $schedule;

        $this->fill($schedule->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['schedule']);

        if ($this->schedule->id) {
            $this->schedule->update($data);
        } else {
            $this->schedule = Schedule::create($data);
        }

        return $this->schedule;
    }
}
