<?php

namespace Sellvation\CCMV2\Ems\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Ems\Models\Email;

class MakeEmailTrackingLinksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Email $email) {}

    public function handle(): void
    {
        $linkIds = [];

        foreach (\EmailCompiler::getLinksFromHtml($this->email->html) as $link) {
            $trackableLink = $this->email->trackableLinks()->updateOrCreate([
                'link' => $link['link'],
            ], $link);

            $linkIds[] = $trackableLink->id;
        }

        $this->email->trackableLinks()->whereNotIn('id', $linkIds)->delete();
    }
}
