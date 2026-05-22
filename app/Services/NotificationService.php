<?php

namespace App\Services;

use App\Interfaces\NotificationInterface;

class NotificationService
{
    protected $notificationRepository;

    public function __construct(NotificationInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getNotificationsData($userId)
    {
        return [
            'unread_count' => $this->notificationRepository->getUnreadCount($userId),
            'notifications' => $this->notificationRepository->getUserNotifications($userId)
        ];
    }

    public function readNotification($userId, $notificationId)
    {
        $isMarked = $this->notificationRepository->markAsRead($userId, $notificationId);

        if (!$isMarked) {
            throw new \Exception('Notifikasi tidak ditemukan.');
        }

        return 'Notifikasi ditandai sudah dibaca.';
    }
}