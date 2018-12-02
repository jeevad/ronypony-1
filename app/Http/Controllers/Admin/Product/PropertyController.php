<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Property;
use AvoRed\Framework\Product\DataGrid\PropertyDataGrid;
use AvoRed\Framework\Product\Requests\PropertyRequest;
use App\Http\Controllers\Controller;
use App\Contracts\Repository\PropertyInterface;

class PropertyController extends Controller
{
    /**
     *
     * @var \App\Repository\PropertyRepository
     */
    protected $repository;

    public function __construct(PropertyInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the Property.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propertyGrid = new PropertyDataGrid($this->repository->query()->orderBy('id', 'desc'));

        return view('avored-framework::product.property.index')
                    ->with('dataGrid', $propertyGrid->dataGrid);
    }

    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored-framework::product.property.create');
    }

    /**
     * Store a newly created property in database.
     *
     * @param \AvoRed\Framework\Product\Requests\PropertyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        $property = $this->repository->create($request->all());

        $this->_saveDropdownOptions($property, $request);

        return redirect()->route('admin.property.index');
    }

    /**
     * Show the form for editing the specified property.
     *
     * @param \App\Models\Property $property
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        return view('avored-framework::product.property.edit')->with('model', $property);
    }

    /**
     * Update the specified property in database.
     *
     * @param \AvoRed\Framework\Product\Requests\PropertyRequest $request
     * @param \App\Models\Property $property
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PropertyRequest $request, Property $property)
    {
        $property->update($request->all());

        $this->_saveDropdownOptions($property, $request);

        return redirect()->route('admin.property.index');
    }

    /**
     * Remove the specified property from storage.
     *
     * @param \App\Models\Property $property
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('admin.property.index');
    }

    /**
     * Get the Element Html in Json Response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getElementHtml(Request $request)
    {
        $properties = $this->repository->findMany('id', $request->get('property_id'))->get();

        $tmpString = str_random();
        $view = view('avored-framework::product.property.get-element')
                        ->with('properties', $properties)
                        ->with('tmpString', $tmpString);

        $json = new JsonResponse(['success' => true, 'content' => $view->render()]);

        return $json;
    }

    /**
     * Save Property Dropdown Field options
     *
     * @param \App\Models\Property $proerty
     * @param \AvoRed\Framework\Product\Request\PropertyRequest $request
     *
     * @return void
     */
    private function _saveDropdownOptions($property, $request)
    {
        if (null !== $request->get('dropdown-options')) {
            $property->propertyDropdownOptions()->delete();

            foreach ($request->get('dropdown-options') as $key => $val) {
                if ($key == '__RANDOM_STRING__') {
                    continue;
                }

                $property->propertyDropdownOptions()->create($val);
            }
        }
    }


    /**
     * Find a Record and Returns a Html Resrouce for that Record
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return view('avored-framework::product.property.show')->with('property', $property);
    }
}
