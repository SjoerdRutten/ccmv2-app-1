<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Notifications;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Overview extends Component
{
    public $checkedNotifications = [];

    public $checkAll = false;

    public $showModal = false;

    public DatabaseNotification $notification;

    public function updated($property, $value)
    {
        if ($property == 'checkAll') {
            if ($value) {
                $this->checkedNotifications = [];

                foreach (Auth::user()->unreadNotifications()->paginate(10) as $notification) {
                    $this->checkedNotifications[] = $notification->id;
                }
            } else {
                $this->checkedNotifications = [];
            }
        }
    }

    public function showNotification(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $this->notification = $notification;
        $this->showModal = true;
    }

    public function markAsRead($all = false)
    {
        if ($all) {
            foreach (Auth::user()->unreadNotifications()->get() as $notification) {
                $notification->markAsRead();
            }
        } else {
            foreach ($this->checkedNotifications as $notificationId) {
                $notification = DatabaseNotification::find($notificationId);
                $notification->markAsRead();
            }
        }

        $this->checkAll = false;
        $this->checkedNotifications = [];
    }

    public function render()
    {
        return view('ccm::livewire.notifications.overview')
            ->with([
                'unreadNotificationsCount' => Auth::user()->unreadNotifications()->count(),
                'unreadNotifications' => Auth::user()->unreadNotifications()->paginate(10, pageName: 'unreadPage'),
                'readNotificationsCount' => Auth::user()->readNotifications()->count(),
                'readNotifications' => Auth::user()->readNotifications()->paginate(10, pageName: 'readPage'),
            ]);
    }
}
