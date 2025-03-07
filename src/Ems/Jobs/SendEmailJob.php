<?php

namespace Sellvation\CCMV2\Ems\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Junges\TrackableJobs\TrackableJob;
use Sellvation\CCMV2\Ems\Models\EmailQueue;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class SendEmailJob extends TrackableJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $jobId = null;

    public function __construct(private readonly EmailQueue $emailQueue)
    {
        parent::__construct();
    }

    public function handle(): string
    {
        $mailserver = $this->selectMailer();

        // Op production mail daadwerkelijk verzenden, op andere environments alleen verzenden als het niet naar een mailing gaat
        if (app()->environment('production') || ! $this->emailQueue->email_mailing_id) {
            $mail = Mail::mailer($mailserver->key_name)
                ->send([], [], function (Message $message) {
                    $message
                        ->to($this->emailQueue->to_email, $this->emailQueue->to_name)
                        ->from($this->emailQueue->from_email, $this->emailQueue->from_name)
                        ->addReplyTo($this->emailQueue->reply_to ?? $this->emailQueue->from_email)
                        ->subject($this->emailQueue->subject)
                        ->html($this->emailQueue->html_content)
                        ->text($this->emailQueue->text_content);
                });

            $this->emailQueue->update([
                'message_id' => $mail->getMessageId(),
                'queued_at' => now(),
                'mail_server_id' => $mailserver->id,
            ]);
        }

        return 'Mail send via mailserver '.$mailserver->id;
    }

    private function selectMailer(): MailServer
    {
        return MailServer::find(4);
    }

    public function trackableType(): ?string
    {
        return $this->emailQueue->getMorphClass();
    }

    public function trackableKey(): ?string
    {
        return (string) $this->emailQueue->id;
    }
}
