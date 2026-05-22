<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderSuccessNotification extends Notification
{
    use Queueable;

    protected $orderId;
    protected $totalCost;

    /**
     * Create a new notification instance.
     */
    public function __construct($orderId, $totalCost)
    {
        $this->orderId = $orderId;
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
            'title' => 'Pesanan Berhasil!',
            'message' => "Hore! Pesanan #{$this->orderId} sebesar $" . $this->totalCost . " sedang kami proses.",
            'action_url' => "/orders/{$this->orderId}"
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
