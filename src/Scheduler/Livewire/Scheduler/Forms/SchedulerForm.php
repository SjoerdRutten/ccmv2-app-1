<?php

namespace Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Scheduler\Models\ScheduledTask;

class SchedulerForm extends Form
{
    use WithFileUploads;

    public ScheduledTask $schedule;

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

    #[Validate]
    public ?array $arguments = [];

    #[Validate]
    public ?array $options = [];

    #[Validate]
    public ?string $start_at;

    #[Validate]
    public ?string $end_at;

    #[Validate]
    public ?array $run_on_days = [];

    #[Validate]
    public ?array $pattern = [];

    #[Validate]
    public bool $on_one_server = false;

    #[Validate]
    public bool $without_overlapping = false;

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
            'start_at' => [
                'nullable',
            ],
            'end_at' => [
                'nullable',
            ],
            'run_on_days' => [
                'array',
            ],
            'pattern' => [
                'array',
            ],
        ];
    }

    public function setModel(ScheduledTask $schedule)
    {
        $this->schedule = $schedule;

        if ($this->schedule->id) {
            $this->fill($schedule->toArray());
        } else {
            $this->options = [];
            $this->arguments = [];
            $this->run_on_days = [];
            $this->pattern = [
                'type' => null,
                'time' => '',
                'day' => 1,
                'month' => 1,
                'days' => [],
            ];
        }
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['schedule']);

        if ($this->schedule->id) {
            $this->schedule->update($data);
        } else {
            $this->schedule = ScheduledTask::create($data);
        }

        return $this->schedule;
    }
}
