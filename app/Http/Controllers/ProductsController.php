<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Filters\ProductFilter;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends Controller
{
    /**
     * @param ProductFilter $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProductFilter $filters)
    {
        $products = Product::with('images')
            ->filter($filters)
            ->paginate($this->_perPage(10));

        if ($products->total()) {
            return ProductResource::collection($products);
        }

        throw new ModelNotFoundException;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('images')->idOrSlug($id)->first();
        if (!$product) {
            throw new ModelNotFoundException;
        }
        return new ProductResource($product);
    }

    private function _perPage($limit = 20): int
    {
        $maxLimit = 30;
        $perPage = request('per_page', $limit);

        return (int)$perPage > $maxLimit ? $maxLimit : $perPage;
    }
}
