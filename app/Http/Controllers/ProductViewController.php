<?php

namespace App\Http\Controllers;

use App\Contracts\Repository\ProductInterface;
use Illuminate\Http\Request;
use App\Contracts\Repository\ProductDownloadableUrlInterface;

class ProductViewController extends Controller
{
    /**
     * Product Repository
     * @var \App\Repository\ProductRepository
     */
    protected $repository;

    /**
    * Product Downloadable Url Repository
    * @var \App\Repository\ProductDownloadableUrlRepository
    */
    protected $downRep;

    public function __construct(
        ProductInterface $repository,
        ProductDownloadableUrlInterface $downRep
        ) {
        parent::__construct();

        $this->repository = $repository;
        $this->downRep = $downRep;
    }

    public function view($slug)
    {
        $product = $this->repository->findBySlug($slug);
        $title = $product->meta_title ?? $product->name;
        $description = $product->meta_description ?? substr($product->description, 0, 255);

        return view('product.view')
                                ->with('product', $product)
                                ->with('title', $title)
                                ->with('description', $description);
    }

    public function downloadDemoProduct(Request $request)
    {
        $downModel = $this->downRep->findByToken($request->get('product_token'));

        $path = storage_path('app/public' . DIRECTORY_SEPARATOR . $downModel->demo_path);
        return response()->download($path);
    }

    public function downloadMainProduct(Request $request)
    {
        $downModel = $this->downRep->findByToken($request->get('product_token'));

        $path = storage_path('app/public' . DIRECTORY_SEPARATOR . $downModel->main_path);
        return response()->download($path);
    }
}
