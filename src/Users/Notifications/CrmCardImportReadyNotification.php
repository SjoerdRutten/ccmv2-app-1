<?php

namespace Sellvation\CCMV2\Users\Notifications;

use Illuminate\Notifications\Notification;
use Sellvation\CCMV2\CrmCards\Models\CrmCardImport;

class CrmCardImportReadyNotification extends Notification
{
    public function __construct(private readonly CrmCardImport $crmCardImport) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Import van bestand '.$this->crmCardImport->file_name.' is gereed',
            'content' => $this->getContent(),
            'crm_card_import_id' => $this->crmCardImport->id,
        ];
    }

    private function getContent(): string
    {
        return
            'Bestandsnaam: '.$this->crmCardImport->file_name.'<br>'.
            'Starttijd: '.$this->crmCardImport->started_at->toDateTimeString().'<br>'.
            'Eindtijd: '.$this->crmCardImport->finished_at->toDateTimeString().'<br>'.
            'Totaal aantal rijen: '.$this->crmCardImport->number_of_rows.'<br>'.
            'Aantal kaarten geupdate: '.$this->crmCardImport->quantity_updated_rows.'<br>'.
            'Aantal kaarten toegevoegd: '.$this->crmCardImport->quantity_created_rows.'<br>'.
            'Aantal lege rijen: '.$this->crmCardImport->quantity_empty_rows.'<br>'.
            'Aantal rijen met fouten: '.$this->crmCardImport->quantity_error_rows;
    }
}
