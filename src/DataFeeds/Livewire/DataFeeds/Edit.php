<?php

namespace Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Forms\DataFeedForm;
use Sellvation\CCMV2\DataFeeds\Models\DataFeed;

class Edit extends Component
{
    use HasModals;

    public DataFeed $dataFeed;

    public DataFeedForm $form;

    public $reference = '';

    public function mount(Datafeed $dataFeed)
    {
        $this->dataFeed = $dataFeed;
        $this->form->setData($this->dataFeed);

        if ($this->dataFeed->id) {
            $this->reference = \Arr::first(\DataFeedConnector::getReferences($this->dataFeed->id));
        }
    }

    public function save()
    {
        $this->dataFeed = $this->form->save();

        $this->showSuccessModal(title: 'Datafeed is opgeslagen', href: route('cms::data_feeds::edit', $this->dataFeed));
    }

    public function render()
    {
        return view('df::livewire.data-feeds.edit')
            ->with([
                'types' => [
                    'https' => 'HTTP(S)',
                    'ftps' => 'FTP(S)',
                    //                    'scp' => 'SCP',
                    //                    'sftp' => 'SFTP',
                    'sql' => 'SQL',
                ],
                'references' => $this->dataFeed->id ? \DataFeedConnector::getReferences($this->dataFeed->id) : [],
                'originalRow' => $this->dataFeed->id ? \DataFeedConnector::getOriginalFirstRow($this->dataFeed->id) : [],
                'dataRow' => $this->dataFeed->id ? \DataFeedConnector::getRow($this->dataFeed->id, $this->reference) : [],
            ]);
    }
}
