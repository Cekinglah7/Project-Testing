<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;
use App\Http\Resources\BannerResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $data = $this->homeService->getHomeData();

        return response()->json([
            'success' => true,
            'message' => 'Home data fetched successfully',
            'data'    => [
                'banners'         => BannerResource::collection($data['banners']),
                'exclusiveOffers' => ProductResource::collection($data['exclusive_offers']),
                'bestSelling'     => ProductResource::collection($data['best_selling']),
                'categories'      => CategoryResource::collection($data['categories']),
            ]
        ], 200);
    }
}
