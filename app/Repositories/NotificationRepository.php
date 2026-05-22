<?php

namespace App\Repositories;

use App\Interfaces\NotificationInterface;
use App\Models\User;

class NotificationRepository implements NotificationInterface
{
    public function getUserNotifications(int $userId)
    {
        return User::find($userId)->notifications;
    }

    public function getUnreadCount(int $userId)
    {
        return User::find($userId)->unreadNotifications->count();
    }

    public function markAsRead(int $userId, string $notificationId)
    {
        $notification = User::find($userId)->notifications()->where('id', $notificationId)->first();
        
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        
        return false;
    }
}