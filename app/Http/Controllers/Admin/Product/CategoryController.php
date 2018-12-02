<?php
namespace App\Http\Controllers\Admin\Product;

use App\Contracts\Repository\CategoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Category;
// use AvoRed\Framework\Product\DataGrid\CategoryDataGrid;
use App\Http\Requests\Admin\Product\CategoryRequest;

class CategoryController extends Controller
{
    /**
     *
     * @var \App\Repository\CategoryRepository
     */
    protected $repository;

    public function __construct(CategoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryGrid = $this->repository->query()->get();
        return view('admin.product.category.index')->with('categories', $categoryGrid);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd($this->repository->options());
        return view('admin.product.category.create')->with('categoryOptions', Category::getCategoryOptions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \AvoRed\Framework\Product\Requests\CategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.product.category.edit')->with('model', $category)
            ->with('categoryOptions', Category::getCategoryOptions());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \AvoRed\Framework\Product\Requests\CategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        foreach ($category->children as $child) {
            $child->parent_id = 0;
            $child->update();
        }

        $category->delete();

        return redirect()->route('admin.category.index');
    }

    /**
     * Find a Record and Returns a Html Resrouce for that Record
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.product.category.show')->with('category', $category);
    }
}
