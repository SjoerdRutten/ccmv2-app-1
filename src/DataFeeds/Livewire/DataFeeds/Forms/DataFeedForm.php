<?php

namespace Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\DataFeeds\Models\DataFeed;

class DataFeedForm extends Form
{
    #[Locked]
    public DataFeed $dataFeed;

    #[Locked]
    public ?int $id = null;

    public string $name = '';

    public ?string $description = null;

    public string $type = '';

    public bool $is_active = false;

    public bool $is_public = false;

    public ?array $feed_config = [];

    public ?array $data_config = [];

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
            'type' => [
                'required',
            ],
            'is_active' => [
                'boolean',
            ],
            'is_public' => [
                'boolean',
            ],
            'feed_config' => [
                'array',
            ],
            'feed_config.url' => [
                'active_url',
                'required_if:feed_config.content_type,https',
            ],
            'feed_config.content_type' => [
                'required_if:feed_config.content_type,https',
            ],
            'feed_config.username' => [
                'nullable',
            ],
            'feed_config.password' => [
                'nullable',
            ],
            'data_config.fields' => [
                'nullable',
                'array',
            ],
            'data_config.reference_key' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function setData(DataFeed $dataFeed): void
    {
        $this->dataFeed = $dataFeed;

        $this->fill($dataFeed->toArray());

        $this->feed_config = $dataFeed->feed_config ?? [];

        $this->getDefaultDataConfig();
    }

    public function save()
    {
        $this->validate();

        $data = $this->all();

        $data = \Arr::only($data, [
            'is_active',
            'is_public',
            'name',
            'description',
            'type',
            'feed_config',
            'data_config',
        ]);

        $this->dataFeed->fill($data);
        $this->dataFeed->save();

        return $this->dataFeed;
    }

    private function getDefaultDataConfig(): void
    {
        if (! $this->data_config) {
            $this->data_config = [
                'fields' => [],
                'reference_key' => '',
            ];

            if ($keys = \DataFeedConnector::getOriginalKeys($this->id)) {
                foreach ($keys as $key => $value) {
                    $this->setDataConfigField($key, $key, $value);
                }
            }
        }
    }

    private function setDataConfigField($key, $getKey, $value): void
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $this->setDataConfigField($key.' > '.$k, $getKey.'.'.$k, $v);
            }
        } else {
            $this->data_config['fields'][$key] = [
                'label' => null,
                'key' => $getKey,
                'visible' => true,
            ];
        }
    }
}
