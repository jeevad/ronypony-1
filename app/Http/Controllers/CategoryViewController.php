<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Contracts\Repository\CategoryInterface;

class CategoryViewController extends Controller
{
    /**
    *
    * @var \App\Repository\CategoryRepository
    */
    protected $repository;

    public function __construct(CategoryInterface $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     *
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\Response
     *
     */
    public function view(Request $request, $slug)
    {
        $productsOnCategoryPage = 9;

        $category = $this->repository->findByKey($slug);

        $catProducts = $this->repository->getCategoryProductWithFilter($category->id, $request->except(['page']));
        $products = $this->repository->paginateProducts($catProducts, $productsOnCategoryPage);

        return view('frontend.category.view')
            ->with('category', $category)
            ->with('params', $request->all())
            ->with('products', $products);
    }
}
