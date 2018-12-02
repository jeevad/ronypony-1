<?php

namespace AvoRed\Framework\System\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Configuration as Model;
use App\Contracts\Repository\ConfigurationInterface;

class ConfigurationController extends Controller
{
    /**
     *
     * @var \App\Repository\ConfigurationRepository
     */
    protected $repository;

    public function __construct(ConfigurationInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Model();
        $pageOptions = Page::Options();
        $countryOptions = Country::options();

        return view('avored-framework::system.configuration.index')
                            ->with('model', $model)
                            ->with('pageOptions', $pageOptions)
                            ->with('countryOptions', $countryOptions);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $configModel = $this->repository->findByKey($key);

            if (null === $configModel) {
                $data['configuration_key'] = $key;
                $data['configuration_value'] = $value;

                $this->repository->create($data);
            } else {
                $configModel->update(['configuration_value' => $value]);
            }
        }

        return redirect()->back()->with('notificationText', 'All Configuration saved!');
    }
}
