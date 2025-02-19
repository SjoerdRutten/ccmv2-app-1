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

    public function mount(Datafeed $dataFeed)
    {
        $this->dataFeed = $dataFeed;
        $this->form->setData($this->dataFeed);
    }

    public function save()
    {
        $this->dataFeed = $this->form->save();

        $this->showSuccessModal(title: 'Datafeed is opgeslagen', href: route('df::edit', $this->dataFeed));
    }

    public function render()
    {
        return view('df::livewire.data-feeds.edit')
            ->with([
                'types' => [
                    'https' => 'HTTP(S)',
                    'ftps' => 'FTP(S)',
                    'scp' => 'SCP',
                    'sftp' => 'SFTP',
                    'sql' => 'SQL',
                ],
            ]);
    }
}
