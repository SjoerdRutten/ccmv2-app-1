<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailContents\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\Ems\Models\EmailCategory;
use Sellvation\CCMV2\Ems\Models\EmailContent;

class EmailContentForm extends Form
{
    #[Locked]
    public EmailContent $emailContent;

    #[Locked]
    public ?int $id = null;

    public ?int $email_category_id = null;

    public string $name = '';

    public ?string $description = null;

    public ?string $start_at = null;

    public ?string $end_at = null;

    public ?string $remarks = null;

    public ?string $content = null;

    public ?string $content_type = null;

    public ?string $unpublished_content = null;

    public ?string $unpublished_content_type = null;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
        ];
    }

    public function setEmailContent(EmailContent $emailContent): void
    {
        $this->emailContent = $emailContent;

        $this->fill($emailContent->toArray());
        $this->start_at = $emailContent->start_at->toDateTimeString();
        $this->end_at = $emailContent->end_at->toDateTimeString();
    }

    public function save()
    {
        $this->validate();

        $data = $this->all();

        $data = \Arr::only($data, [
            'email_category_id',
            'name',
            'description',
            'remarks',
            'start_at',
            'end_at',
            'content',
            'content_type',
            'unpublished_content',
            'unpublished_content_type',
        ]);

        $this->emailContent->fill($data);
        $this->emailContent->save();

    }

    public function categories()
    {
        return EmailCategory::query()
            ->orderBy('name')
            ->get();
    }
}
