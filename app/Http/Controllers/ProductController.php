<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        try {
           $filters = [
                'categories' => $request->input('categories'),
                'brands'     => $request->input('brands'),
                'search'     => $request->query('search')
            ];
            
            $products = $this->productService->getProducts($filters);
            $resource = ProductResource::collection($products)->response()->getData(true);

            return Notification::success($resource, 'Berhasil mengambil daftar produk');

        } catch (\Exception $e) {
            return Notification::error('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->validated());
            $resource = new ProductResource($product);

            return Notification::success($resource, 'Produk berhasil ditambahkan', 201);
        } catch (\Exception $e) {
            return Notification::error('Gagal menambahkan produk: ' . $e->getMessage(), 500);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = $this->productService->updateProduct($id, $request->validated());
            $resource = new ProductResource($product);

            return Notification::success($resource, 'Produk berhasil diperbarui');
        } catch (\Exception $e) {
            return Notification::error('Gagal memperbarui produk: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getDetail($id);
            
            return Notification::success(new ProductResource($product), 'Detail produk berhasil diambil');

        } catch (\Exception $e) {
            return Notification::error($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);

            return Notification::success(null, 'Produk dan gambar berhasil dihapus!');

        } catch (\Exception $e) {
            return Notification::error('Gagal menghapus: ' . $e->getMessage(), 500);
        }
    }
}