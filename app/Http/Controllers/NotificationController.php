<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $data = $this->notificationService->getNotificationsData(Auth::id());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil notifikasi',
            'data' => [
                'unreadCount' => $data['unread_count'],
                'notifications' => NotificationResource::collection($data['notifications']) 
            ]
        ], 200);
    }

    public function markAsRead($id)
    {
        try {
            $message = $this->notificationService->readNotification(Auth::id(), $id);

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
