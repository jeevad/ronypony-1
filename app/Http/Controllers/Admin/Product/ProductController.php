<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\AttributeDropdownOption;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Category;
use App\Facades\Image;
use App\Http\Requests\Admin\Product\ProductRequest;
// use AvoRed\Framework\Product\DataGrid\ProductDataGrid;
use App\Contracts\Repository\ProductInterface;
use App\Models\ProductDownloadableUrl;
use App\Repository\ProductDownloadableUrlRepository;
use App\Contracts\Repository\ProductDownloadableUrlInterface;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    /**
     *
     * @var \App\Repository\ProductRepository
     */
    protected $repository;

    /**
     *
     * @var \App\Repository\ProductDownloadableUrlRepository
     */
    protected $downRepository;

    public function __construct(ProductInterface $repository, ProductDownloadableUrlInterface $downRep)
    {
        $this->repository       = $repository;
        $this->downRepository   = $downRep;
    }

    

    /**
     * Display a listing of the resource.
     * r.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsBuilder = $this->repository->query()->where('type', '!=', 'VARIABLE_PRODUCT')->orderBy('id', 'desc');
        // $productGrid = new ProductDataGrid($productsBuilder);
        $productGrid = $productsBuilder->get();

        return view('admin.product.index')->with('products', $productGrid);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     * @todo Change the ProductRequest Validation Rules for Store and Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $product = Product::create($request->all());
        } catch (\Exception $e) {
            echo 'Error in Saving Product: ', $e->getMessage(), "\n";
        }

        //rather then redirect we just execute Edit Method here.
        // Not sure if this is a good idea???

        return redirect()->route('admin.product.edit', ['id' => $product->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $attributes = Collection::make([]);

        // $properties = Property::all()->pluck('name', 'id');
        // $usedForAllProductProperties = Property::whereUseForAllProducts(1)->get();

        // if ($product->type == 'VARIATION') {
        //     $attributes = AttributeDropdownOption::all()->pluck('name', 'id');
        // }
        $storageOptions = []; //Storage::pluck('name', 'id');
        return view('admin.product.edit')
            ->with('model', $product)
            ->with('categoryOptions', Category::getCategoryOptions())
            ->with('storageOptions', $storageOptions);
            // ->with('propertyOptions', $properties)
            // ->with('usedForAllProductProperties', $usedForAllProductProperties)
            // ->with('attributeOptions', $attributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\Product\ProductRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Exception
     */
    public function update(ProductRequest $request, Product $product)
    {
        //dd($request->all());
        try {
            //$product = ProductModel::findorfail($id);
            $product->saveProduct($request->all());
        } catch (\Exception $e) {
            throw new \Exception('Error in Saving Product: ' . $e->getMessage());
        }

        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()->route('admin.product.index');
    }

    /**
     * upload image file and re sized it.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        $image = $request->image;
        $product_id = $request->product_id;
        // die($product_id);
        $tmpPath = str_split(strtolower(str_random(3)));
        // $checkDirectory = 'uploads/catalog/images/'.$request->product_id;
        $checkDirectory = config('site.image.path').$request->product_id;
        $dbPath = $checkDirectory . '/' . $image->getClientOriginalName();

        $image = Image::upload($image, $checkDirectory);

        $tmp = $this->_getTmpString();

        return view('admin.product.upload-image')
            ->with('image', $image)
            ->with('tmp', $tmp);
    }

    /**
     * upload image file and resized it.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $path = $request->get('path');

        $path = 'uploads/catalog/images/e/0/v/1382542458778.jpeg';
        $fileName = pathinfo($path, PATHINFO_BASENAME);
        $relativeDir = pathinfo($path, PATHINFO_DIRNAME);

        $sizes = config('site.image.sizes');
        foreach ($sizes as $sizeName => $widthHeight) {
            $imagePath = $relativeDir . DIRECTORY_SEPARATOR . $sizeName . '-' . $fileName;
            if (File::exists($imagePath)) {
                File::delete(storage_path('app/public/' . $imagePath));
            }
        }

        if (File::exists($path)) {
            File::delete(storage_path('app/public/' . $path));
        }
        return JsonResponse::create(['success' => true]);
    }

    /**
     * Products Downloadable Main Media Download.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadMainToken($token)
    {
        $downloadableUrl = $this->downRepository->findByToken($token);
        $path = storage_path("app/public" . DIRECTORY_SEPARATOR. $downloadableUrl->main_path);

        return response()->download($path);
    }

     /**
     * Products Downloadable Main Media Download.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadDemoToken($token)
    {
        $downloadableUrl = $this->downRepository->findByToken($token);
        $path = storage_path("app/public" . DIRECTORY_SEPARATOR. $downloadableUrl->demo_path);

        return response()->download($path);
    }

    /**
     * upload image file and resized it.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editVariation(Request $request)
    {
        $product = Product::findorfail($request->get('variation_id'));
        $view = view('admin.product.variation-modal')
                            ->with('model', $product);

        return new JsonResponse(['success' => true, 'content' => $view->render(), 'modalId' => '#variation-modal-' . $product->id]);
    }

    /**
     * return random string only lower and without digits.
     *
     * @param int $length
     * @return string $randomString
     */
    public function _getTmpString($length = 6)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    
    /**
     * return random string only lower and without digits.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
        return view('admin.product.show')
                ->with('product', $product);
    }


}
