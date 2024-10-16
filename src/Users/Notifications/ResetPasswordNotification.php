<?php

namespace Sellvation\CCMV2\Users\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Wachtwoord opnieuw instellen')
            ->line('Je ontvangt deze mail omdat er een wachtwoord reset is aangevraagd voor je account.')
            ->action('Nieuw wachtwoord instellen', $url)
            ->line('Deze link is '.config('auth.passwords.'.config('auth.defaults.passwords').'.expire').' minuten geldig.')
            ->line('Als je de reset niet zelf hebt aangevraagd hoef je niks te doen');
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return url(route('reset-password-form', [
            'token' => $this->token,
            'name' => $notifiable->name,
        ], false));
    }
}
