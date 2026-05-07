<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FavoriteService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ToggleFavoriteRequest;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function index()
    {
        $favorites = $this->favoriteService->getFavorites(Auth::id());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar favorite',
            'data'    => $favorites
        ], 200);
    }

    public function toggle(ToggleFavoriteRequest $request)
    {
        $result = $this->favoriteService->toggleFavorite(Auth::id(), $request->product_id);

        return response()->json([
            'success' => true,
            'is_favorited' => $result['is_favorited'],
            'message' => $result['message']
        ], 200);
    }
}
