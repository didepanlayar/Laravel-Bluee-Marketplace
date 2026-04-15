<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'row_per_page' => 'required|integer'
        ]);

        try {
            $products = $this->productRepository->getAllPaginated($request['search'] ?? null, $request['product_category_id'] ?? null, $request['row_per_page']);

            return ResponseHelper::jsonResponse(true, 'Data retrieved successfully.', PaginateResource::make($products, ProductResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $products = $this->productRepository->getAll($request->search, $request->product_category_id, $request->limit, true);

            return ResponseHelper::jsonResponse(true, 'Data retrieved successfully.', ProductResource::collection($products), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = $this->productRepository->getById($id);

            if (!$product) {
                return ResponseHelper::jsonResponse(true, 'Data not found.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data retrieved successfully.', new ProductResource($product), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
