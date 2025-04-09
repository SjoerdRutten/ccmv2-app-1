<?php

namespace Sellvation\CCMV2\CrmCards\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class UpdateCrmCardMongoDbJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private CrmCard|\stdClass $crmCard)
    {
        $this->queue = 'scout';

        if ($crmCard instanceof \stdClass) {
            $this->crmCard = CrmCard::whereCrmId($crmCard->crmid)->first();
        }

    }

    public function handle(): void
    {
        $data = $this->crmCard->toArray();
        $data['mongo_updated_at'] = now();

        \Arr::forget($data, ['data']);

        foreach (
            CrmField::whereEnvironmentId($this->crmCard->environment_id)
                ->get() as $crmField
        ) {
            switch ($crmField->type) {
                case 'BOOLEAN':
                case 'CONSENT':
                    $data[$crmField->name] = (bool) \Arr::get($this->crmCard->data, $crmField->name);
                    break;
                case 'DATETIME':
                    $data[$crmField->name] = $this->makeTimestamp(\Arr::get($this->crmCard->data, $crmField->name));

                    break;
                case 'DECIMAL':
                    $data[$crmField->name] = (float) \Arr::get($this->crmCard->data, $crmField->name);
                    break;
                case 'INT':
                    $data[$crmField->name] = (int) \Arr::get($this->crmCard->data, $crmField->name);
                    break;
                case 'EMAIL':
                    $data[$crmField->name] = \Arr::get($this->crmCard->data, $crmField->name);
                    //                    $data[$crmField->name.'_infix'] = $this->makeStringArray(\Arr::get($this->crmCard->data, $crmField->name));
                    $data['_'.$crmField->name.'_valid'] = $this->isEmailaddressValid($this->crmCard->data, $crmField->name);
                    $data['_'.$crmField->name.'_possible'] = $this->isEmailaddressPossible($this->crmCard->data, $crmField->name);
                    $data['_'.$crmField->name.'_abuse'] = (bool) \Arr::get($this->crmCard->data, '_'.$crmField->name.'_abuse');
                    $data['_'.$crmField->name.'_abuse_timestamp'] = $this->makeTimestamp(\Arr::get($this->crmCard->data, '_'.$crmField->name.'_abuse_timestamp'));
                    $data['_'.$crmField->name.'_bounce_reason'] = \Arr::get($this->crmCard->data, '_'.$crmField->name.'_bounce_reason');
                    $data['_'.$crmField->name.'_bounce_score'] = (int) \Arr::get($this->crmCard->data, '_'.$crmField->name.'_bounce_score');
                    $data['_'.$crmField->name.'_bounce_type'] = \Arr::get($this->crmCard->data, '_'.$crmField->name.'_bounce_type');
                    $data['_'.$crmField->name.'_type'] = \Arr::get($this->crmCard->data, '_'.$crmField->name.'_type');
                    break;
                case 'MEDIA':
                    $data['_'.$crmField->name.'_allowed'] = $this->isEmailaddressAllowed($this->crmCard->data, $crmField->name);
                    $data['_'.$crmField->name.'_optin'] = (bool) \Arr::get($this->crmCard->data, '_'.$crmField->name.'_optin');
                    $data['_'.$crmField->name.'_optin_timestamp'] = $this->makeTimestamp(\Arr::get($this->crmCard->data, '_'.$crmField->name.'_optin_timestamp'));
                    $data['_'.$crmField->name.'_confirmed_optin'] = (bool) \Arr::get($this->crmCard->data, '_'.$crmField->name.'_confirmed_optin');
                    $data['_'.$crmField->name.'_confirmed_optin_timestamp'] = $this->makeTimestamp(\Arr::get($this->crmCard->data, '_'.$crmField->name.'_confirmed_optin_timestamp'));
                    $data['_'.$crmField->name.'_confirmed_optout'] = (bool) \Arr::get($this->crmCard->data, '_'.$crmField->name.'_confirmed_optout');
                    $data['_'.$crmField->name.'_optout_timestamp'] = $this->makeTimestamp(\Arr::get($this->crmCard->data, '_'.$crmField->name.'_optout_timestamp'));
                    break;
                case 'TEXTBIG':
                case 'TEXTMICRO':
                case 'TEXTMIDDLE':
                case 'TEXTMINI':
                case 'TEXTSMALL':
                default:
                    $data[$crmField->name] = \Arr::get($this->crmCard->data, $crmField->name);
                    //                    $data[$crmField->name.'_infix'] = $this->makeStringArray(\Arr::get($this->crmCard->data, $crmField->name));

            }
        }

        \Context::add('environment_id', $this->crmCard->environment_id);

        if ($crmCard = CrmCardMongo::where('id', $this->crmCard->id)->first()) {
            $crmCard->update($data);
        } else {
            CrmCardMongo::create($data);
        }
    }

    private function makeStringArray($string)
    {
        $data = [];
        foreach (explode(' ', $string) as $elm) {
            do {
                $data[] = $elm;
                $elm = Str::substr($elm, 1);
            } while (strlen($elm) > 2);
        }

        return $data;
    }

    private function makeTimestamp($value)
    {
        if ($value) {
            try {
                $timestamp = Carbon::parse($value)->toIso8601String();

                return $timestamp < 0 ? null : $timestamp;
            } catch (\Exception $e) {
            }
        }

        return null;
    }

    private function isEmailaddressValid(array $data, string $name): bool
    {
        $validator = \Validator::make(['email' => \Arr::get($data, $name)], ['email' => 'required|email:rfc']);

        return $validator->passes();
    }

    private function isEmailaddressPossible(array $data, string $name): bool
    {
        if (
            ($this->isEmailaddressValid($data, $name)) &&
            (! \Arr::get($data, '_'.$name.'_abuse')) &&
            (\Arr::get($data, '_'.$name.'_bounce_type') !== 'hard') &&
            (\Arr::get($data, '_'.$name.'_bounce_score') < 3)
        ) {
            return true;
        }

        return false;
    }

    private function isEmailaddressAllowed(array $data, string $name): bool
    {
        if (
            (\Arr::get($data, '_'.$name.'_optin')) &&
            (\Arr::get($data, '_'.$name.'_confirmed_optin')) &&
            (! \Arr::get($data, '_'.$name.'_confirmed_optout'))
        ) {
            return true;
        }

        return false;
    }
}
