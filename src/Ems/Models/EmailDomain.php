<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Spatie\Dns\Dns;

class EmailDomain extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'domain',
        'description',
        'return_path',
        'dkim_selector_prefix',
        'dkim_private_key',
        'dkim_public_key',
        'dkim_expires_at',
        'dkim_status',
        'dkim_status_message',
    ];

    protected $casts = [
        'dkim_expires_at' => 'datetime:Y-m-d H:i',
    ];

    protected function dkimRecordKey(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->dkim_selector_prefix.'._domainkey'
        );
    }

    protected function dkimDomainRecord(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->domain && $this->dkim_selector_prefix ? $this->dkimRecordKey.'.'.$this->domain : false
        );
    }

    protected function dkimRecordValue(): Attribute
    {
        return Attribute::make(
            get: fn () => 'v=DKIM1;p='.\Str::replace(['-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'], '', $this->dkim_public_key)
        );
    }

    protected function hasDkim(): Attribute
    {
        return Attribute::make(
            get: fn () => ! empty($this->dkim_private_key) && ! empty($this->dkim_private_key) && ! empty($this->dkim_selector_prefix),
        );
    }

    protected function dkimCheck(): Attribute
    {
        $this->dkim_status = 0;

        if ($this->dkimDomainRecord) {
            $dns = new Dns;
            try {
                $records = $dns->getRecords($this->dkimDomainRecord, 'TXT');
            } catch (\Exception $e) {
                $this->dkim_status_message = 'Kon record niet ophalen';

                $this->saveQuietly();

                return Attribute::make(
                    get: fn () => false,
                );
            }

            if (count($records)) {
                foreach ($records as $record) {
                    if ($record->txt() === $this->dkimRecordValue) {
                        $this->dkim_status = 1;
                        $this->dkim_status_message = null;

                        $this->saveQuietly();

                        return Attribute::make(
                            get: fn () => true,
                        );
                    }
                }
            } else {
                $this->dkim_status_message = 'Geen correct TXT-record gevonden';
            }

            $this->saveQuietly();
        }

        return Attribute::make(
            get: fn () => false,
        );
    }
}
