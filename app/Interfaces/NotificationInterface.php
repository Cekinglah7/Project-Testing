<?php

namespace App\Interfaces;

interface NotificationInterface
{
    public function getUserNotifications(int $userId);
    public function getUnreadCount(int $userId);
    public function markAsRead(int $userId, string $notificationId);
}
