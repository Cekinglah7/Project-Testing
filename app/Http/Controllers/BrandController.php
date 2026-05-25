<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            $brands = $this->brandService->getBrands($search);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data brand',
                'data'    => BrandResource::collection($brands)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
