<?php

namespace AvoRed\Framework\System\Controllers;

use App\Contracts\Repository\SiteCurrencyInterface;
use AvoRed\Framework\System\DataGrid\SiteCurrencyDataGrid;
use AvoRed\Framework\System\Requests\SiteCurrencyRequest;
use App\Models\SiteCurrency;

class SiteCurrencyController extends Controller
{
    /**
     *
     * @var \App\Repository\SiteCurrencyRepository
     */
    protected $repository;

    public function __construct(SiteCurrencyInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siteCurrencyGrid = new SiteCurrencyDataGrid($this->repository->query());

        return view('avored-framework::system.site-currency.index')
                    ->with('dataGrid', $siteCurrencyGrid->dataGrid);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored-framework::system.site-currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \AvoRed\Framework\System\Requests\SiteCurrencyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SiteCurrencyRequest $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('admin.site-currency.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\SiteCurrency $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->repository->find($id);
        return view('avored-framework::system.site-currency.edit')
                    ->with('model', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \AvoRed\Framework\System\Requests\SiteCurrencyRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SiteCurrencyRequest $request, $id)
    {
        $siteCurrency = $this->repository->find($id);
        $siteCurrency->update($request->all());

        return redirect()->route('admin.site-currency.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siteCurreny = $this->repository->find($id);
        $siteCurreny->delete();
        return redirect()->route('admin.site-currency.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SiteCurrency $siteCurrency)
    {
        return view('avored-framework::system.site-currency.show')->with('siteCurrency', $siteCurrency);
    }
}
