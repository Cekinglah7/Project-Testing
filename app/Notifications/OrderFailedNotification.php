<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderFailedNotification extends Notification
{
    use Queueable;

    protected $reason;
    protected $totalCost;

    /**
     * Create a new notification instance.
     */
    public function __construct($reason, $totalCost)
    {
        $this->reason = $reason;
        $this->totalCost = $totalCost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return [
            'type' => 'error',
            'title' => 'Oops! Order Failed',
            'message' => "Pesananmu senilai $" . $this->totalCost . " gagal diproses karena: {$this->reason}.",
            'action_url' => '/cart'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
